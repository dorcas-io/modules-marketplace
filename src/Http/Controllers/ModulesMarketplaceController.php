<?php

namespace Dorcas\ModulesMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dorcas\ModulesMarketplace\Models\ModulesMarketplace;
use App\Dorcas\Hub\Utilities\UiResponse\UiResponse;
use App\Http\Controllers\HomeController;
use Hostville\Dorcas\Sdk;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ModulesMarketplaceController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data = [
            'page' => ['title' => config('modules-marketplace.title')],
            'header' => ['title' => config('modules-marketplace.title')],
            'selectedMenu' => 'addons',
            'submenuConfig' => 'navigation-menu.addons.sub-menu.modules-marketplace.sub-menu',
            'submenuAction' => ''
        ];
        $this->data['currentPage'] = 'professional_directory';
        $this->data['viewMode'] = 'professional';
    }


    public function index()
    {
    	return view('modules-marketplace::index', $this->data);
    }


    /**
     * @param Request     $request
     * @param Sdk         $sdk
     *
     * @param string|null $viewTemplate
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function marketplace(Request $request, Sdk $sdk, string $viewTemplate = null)
    {
        if (empty($viewTemplate)) {
            $this->data['page']['title'] .= ' &rsaquo; Services';
            $this->data['header']['title'] .= ' &rsaquo; Professional Services';
            $this->data['selectedSubMenu'] = 'marketplace-services';
        }

        $this->setViewUiResponse($request);
        $view = strtolower($request->query('view', 'listing'));
        $this->data['categories'] = $categories = $this->getProfessionalServiceCategories($sdk);
        $this->data['view'] = $view = empty($categories) ? 'listing' : $view;
        $this->data['query'] = $request->query->all();
        $this->data['query']['mode'] = $this->data['viewMode'];

        //setup categories link
        $this->data['submenuAction'] = '
            <div class="dropdown"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Categories</button>
                <div class="dropdown-menu">';

        foreach ($categories as $cat) {

            if ($this->data['viewMode']=='vendor') {
                $rlink = route('marketplace-products').'?category_id='.$cat->id;
            } else {
                $rlink = route('marketplace-services').'?category_id='.$cat->id;
            }

            $this->data['submenuAction'] .= '<a href="'.$rlink.'" class="dropdown-item">'.ucfirst($cat->name).' ('.$cat->counts["services"].')</a>';
        }


        $this->data['submenuAction'] .= '
                </div>
            </div>
        ';


        if ($view !== 'categories') {
            $categoryId = $request->query('category_id', null);
            if (!empty($categories)) {
                $category = $categories->where('id', $categoryId)->first();
                if (!empty($category)) {
                    $this->data['page']['title'] .= ' (' . title_case($category->name) . ')';
                    $this->data['header']['title'] .= ' (' . title_case($category->name) . ')';
                    //$entry = ['text' => 'By Category', 'href' => route('directory') .'?view=categories'];
                    //array_splice($this->data['breadCrumbs']['crumbs'], 0, 0, [$entry]);
                }
            } else {
                unset($this->data['query']['category_id']);
                # unset it, if it already exists
            }
        }
        $viewTemplate = $viewTemplate ?: 'modules-marketplace::marketplace'; //'modules-marketplace::index'
        return view($viewTemplate, $this->data);
    }
    
    /**
     * @param Request $request
     * @param Sdk     $sdk
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function marketplaceVendors(Request $request, Sdk $sdk)
    {
        $this->data['page']['title'] .= ' &rsaquo; Products';
        $this->data['header']['title'] .= ' &rsaquo; Vendor Products';
        $this->data['selectedSubMenu'] = 'marketplace-products';
        //$this->data['submenuAction'] = '<a href="'.route("customers-new").'" class="btn btn-primary btn-block">Add Customer</a>';

        $request->query->set('mode', 'vendor');
        $this->data['vendorMode'] = true;
        $this->data['viewMode'] = 'vendor';
        //return $this->marketplace($request, $sdk);
        return $this->marketplace($request, $sdk, 'modules-marketplace::marketplace');
    }



    /**
     * @param Request     $request
     * @param Sdk         $sdk
     *
     * @param string|null $viewTemplate
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacts(Request $request, Sdk $sdk)
    {
        if (empty($viewTemplate)) {
            $this->data['page']['title'] .= ' &rsaquo; Contacts';
            $this->data['header']['title'] .= ' &rsaquo; Preferred Contacts';
            $this->data['selectedSubMenu'] = 'marketplace-contacts-main';
        }

        $this->setViewUiResponse($request);
        
        return view('modules-marketplace::contacts', $this->data);
    }


    /**
     * @param Request $request
     * @param Sdk     $sdk
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, Sdk $sdk)
    {
        $search = $request->query('search', '');
        $sort = $request->query('sort', '');
        $order = $request->query('order', 'asc');
        $offset = (int) $request->query('offset', 0);
        $limit = (int) $request->query('limit', 10);
        $mode = strtolower($request->query('mode', 'professional'));
        # get the request parameters
        $query = $sdk->createDirectoryResource();
        $query = $query->addQueryArgument('limit', $limit)
                        ->addQueryArgument('page', get_page_number($offset, $limit))
                        ->addQueryArgument('mode', $mode);
        if ($request->query->has('category_id')) {
            $query = $query->addQueryArgument('category_id', $request->query('category_id'));
        }
        if (!empty($search)) {
            $query = $query->addQueryArgument('search', $search);
        }
        $response = $query->send('get', ['services']);
        # make the request
        if (!$response->isSuccessful()) {
            // do something here
            throw new RecordNotFoundException($response->errors[0]['title'] ?? 'Could not find any matching professionals in the directory.');
        }
        $this->data['total'] = $response->meta['pagination']['total'] ?? 0;
        # set the total
        $this->data['rows'] = $response->data;
        # set the data
        return response()->json($this->data);
    }
    
    /**
     * @param Request $request
     * @param Sdk     $sdk
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function vendorContacts(Request $request, Sdk $sdk)
    {
        $search = $request->query('search', '');
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        $query = $sdk->createCompanyService()->addQueryArgument('page', $page)
                                            ->addQueryArgument('limit', $limit);
        if (!empty($search)) {
            $query = $query->addQueryArgument('search', $search);
        }
        $response = $query->send('GET', ['contacts']);
        # make the request
        if (!$response->isSuccessful()) {
            // do something here
            throw new RecordNotFoundException($response->errors[0]['title'] ?? 'Could not find any matching contacts in the directory.');
        }
        $this->data['meta'] = $response->meta;
        $this->data['total'] = $response->meta['pagination']['total'] ?? 0;
        # set the total
        $this->data['rows'] = $response->data;
        # set the data
        return response()->json($this->data);
    }
    
    /**
     * @param Request $request
     * @param Sdk     $sdk
     * @param string  $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeContact(Request $request, Sdk $sdk, string $id)
    {
        $response = $sdk->createCompanyService()->send('DELETE', ['contacts', $id]);
        # send the delete request
        if (!$response->isSuccessful()) {
            throw new RecordNotFoundException($response->errors[0]['title'] ?? 'Could not remove the contact.');
        }
        return response()->json($response->getData());
    }


    /**
     * @param Request $request
     * @param Sdk     $sdk
     * @param string  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function service(Request $request, Sdk $sdk, string $id)
    {
        $this->data['page']['title'] .= ' &rsaquo; Service';
        $this->data['header']['title'] .= ' &rsaquo; Service';
        $this->data['selectedSubMenu'] = 'marketplace-services';

        $this->setViewUiResponse($request);

        $this->data['service'] = $service = Cache::remember('directory.service.'.$id, 30, function () use ($id, $sdk) {
            $query = $sdk->createDirectoryResource()
                            ->addQueryArgument('include', 'user.professional_credentials,user.professional_experiences')
                            ->send('GET', ['services', $id]);
            if (!$query->isSuccessful()) {
                return null;
            }
            return $query->getData(true);
        });
        $isContact = false;
        $contactQuery = $sdk->createCompanyService()->addQueryArgument('user_id', $service->user['data']['id'])
                                                    ->send('GET', ['contacts']);
        if ($contactQuery->isSuccessful()) {
            # it was successful
            $isContact = !empty($contactQuery->getData());
        }
        if ($request->query->has('add_contact') && !$isContact) {
            $query = $sdk->createCompanyService()->addBodyParam('user_id', $service->user['data']['id'])
                                                ->send('POST', ['contacts']);
            # try to add the contact
            if ($query->isSuccessful()) {
                # it was successful
                $isContact = true;
            }
        }
        $this->data['is_contact'] = $isContact;
        $this->data['page']['title'] .= ' (' . $service->title. ')';
        $this->data['header']['title'] .= ' (' . $service->title. ')';
        return view('modules-marketplace::service', $this->data);
    }
    
    /**
     * @param Request $request
     * @param Sdk     $sdk
     * @param string  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function serviceRequest(Request $request, Sdk $sdk, string $id)
    {
        $this->validate($request, [
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:6144',
        ], [
            'attachment.max' => 'The attachment should not be greater than 6Mb, you can compress the file into an archive.'
        ]);
        # validate the request
        try {
            $attachment = $request->file('attachment', null);
            # get the attachment, if any
            $query = $sdk->createDirectoryResource()->addBodyParam('message', $request->message);
            if (!empty($attachment)) {
                $query = $query->addMultipartParam(
                    'attachment',
                    file_get_contents($attachment->getRealPath()),
                    $attachment->getClientOriginalName()
                );
            }
            $response = $query->send('post', ['services', $id, 'requests']);
            # send the request
            if (!$response->isSuccessful()) {
                throw new \RuntimeException($response->errors[0]['title'] ?? 'Failed while sending the request. Please try again.');
            }
            $message = ['Successfully sent the service request, expect to hear back from them soon.'];
            $response = (tabler_ui_html_response($message))->setType(UiResponse::TYPE_SUCCESS);
        } catch (\Exception $e) {
            $response = (tabler_ui_html_response([$e->getMessage()]))->setType(UiResponse::TYPE_ERROR);
        }
        return redirect(url()->current())->with('UiResponse', $response);
    }


}