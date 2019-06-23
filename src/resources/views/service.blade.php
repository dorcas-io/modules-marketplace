@extends('layouts.tabler')
@section('body_content_header_extras')

@endsection

@section('body_content_main')

@include('layouts.blocks.tabler.alert')

<div class="row" id="service_profile">
    @include('layouts.blocks.tabler.sub-menu')

    <div class="col-md-12 col-lg-3">
        <div class="card card-profile">
            <div class="card-header" v-bind:style="{ 'background-image': 'url(' + backgroundImage + ')' }"></div>
            <div class="card-body text-center">
                <img class="card-profile-img" v-bind:src="photo">
                <h3 class="mb-3">@{{ service.title }}</h3>
                <p class="mb-4">
                    <div class="list-group text-left">
                        <p class="list-group-item"><i class="fa fa-money"></i> @{{ service.cost_currency }}@{{ service.cost_amount.formatted + (service.cost_frequency.toLowerCase() !== 'standard' ? ' per ' + service.cost_frequency : '') }}</p>
                        <p class="list-group-item"><i class="fe fe-user" aria-hidden="true"></i> @{{ service.user.data.firstname }} @{{ service.user.data.lastname }}</p>
                        <p class="list-group-item"><i class="fe fe-at-sign" aria-hidden="true"></i> @{{ service.user.data.email }}</p>
                        <p class="list-group-item"><i class="fe fe-phone" aria-hidden="true"></i> @{{ service.user.data.phone }}</p>
                        <p class="list-group-item"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> @{{ addedDate }}</p>
                        <div class="tag" v-for="category in service.categories.data" :key="category.id">
                          @{{ category.name.title_case() }}
                          <a v-bind:href="'{{ route('marketplace-services') . '?category_id=' }}' + category.id" target="_blank" class="tag-addon tag-primary"><i class="fe fe-external-link" data-ignore-click="true"></i></a>
                        </div>
                    </div>
                </p>
                <a href="{{ url('/mmp/marketplace-services') . '/' . $service->id . '?add_contact' }}"  class="btn btn-outline-primary btn-sm text-center {{ $is_contact ? 'disabled' : '' }}">
                    <span class="fa fa-address-card"></span> Add to Contacts
                </a>
            </div>
        </div>
    </div>


    <div class="col-md-12 col-lg-6">
        <div class="card">
            <div class="card-status bg-blue"></div>
            <div class="card-body">
                Engage <strong>@{{ fullName }}&apos;s</strong> Service:
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#service_credentials">Credentials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#service_experience">Experience</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#service_request_service">Request Service</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane container active" id="service_credentials">
                        <br/>
                        <div class="row section" id="credentials-list">
                            <div class="card col-md-12" v-for="credential in credentials" :key="credential.id">
                                <div class="card-status bg-cyan"></div>
                                <div class="card-header">
                                    <h3 class="card-title">@{{ credential.title }}</h3>
                                </div>
                                <div class="card-body">
                                    <h5>@{{ credential.certification }} (@{{ credential.year }})</h5>
                                    <p>@{{ credential.description }}</p>
                                </div>
                            </div>

                            <div class="col s12" v-if="credentials.length === 0">
                                @component('layouts.blocks.tabler.empty-fullpage')
                                    @slot('title')
                                        Credentials
                                    @endslot
                                    This professional has not added any credentials.
                                    @slot('buttons')
                                    @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container" id="service_experience">
                        <br/>
                        <div class="row section" id="experiences-list">
                            <div class="card col-md-12" v-for="experience in experiences" :key="experience.id">
                                <div class="card-status bg-cyan"></div>
                                <div class="card-header">
                                    <h3 class="card-title">@{{ experience.company }} (@{{ experience.from_year + ' - ' + (experience.is_current ? 'Present' : experience.to_year) }})</h3>
                                </div>
                                <div class="card-body">
                                    <h5>@{{ experience.designation }}</h5>
                                </div>
                            </div>

                            <div class="col s12" v-if="experiences.length === 0">
                                @component('layouts.blocks.tabler.empty-fullpage')
                                    @slot('title')
                                        Experience
                                    @endslot
                                    This professional has not added any work experience information.
                                    @slot('buttons')
                                    @endslot
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container" id="service_request_service">
                        <br/>
                        <div class="row col-md-12">
                            <form class="col s12" action="" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col s12">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <textarea class="form-control" name="message" required></textarea>
                                                <label class="form-label" for="message" class="active">Personal Message</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <div class="form-label">Any Supporting Documents?</div>
                                                <div class="custom-file">
                                                    <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip,image/*" class="custom-file-input">
                                                    <label class="custom-file-label">Choose Attachment</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn btn-outline-primary" type="submit" name="action">Send Request</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('body_js')
    <script type="text/javascript">

        new Vue({
            el: '#service_profile',
            data: {
                is_contact: {!! json_encode($is_contact) !!},
                service: {!! json_encode($service) !!},
                credentials: {!! json_encode(!empty($service->user['data']['professional_credentials']) ? $service->user['data']['professional_credentials']['data'] : [] ) !!},
                experiences: {!! json_encode(!empty($service->user['data']['professional_experiences']) ? $service->user['data']['professional_experiences']['data'] : [] ) !!},
                defaultPhoto: "{{ cdn('images/avatar/avatar-9.png') }}",
                backgroundImage: "{{ cdn('images/gallery/14.png') }}",
            },
            computed: {
                photo: function () {
                    return this.service.user.data.photo.length > 0 ? this.service.user.data.photo : this.defaultPhoto;
                },
                fullName: function () {
                    var names = [this.service.user.data.firstname || '', this.service.user.data.lastname || ''];
                    return names.join(' ').title_case();
                },
                addedDate: function () {
                    return moment(this.service.user.data.created_at).format('DD MMM, YYYY')
                }
            },
            methods: {
                addedContactOnLoad() {
                    //open Tab
                    var url = document.location.toString();
                    if (url.match('add_contact') && this.is_contact) {
                        swal("Contact Added!", "The contact was successfully added to your contacts list", "success");
                    }
                }
            },
            mounted: function () {
                //console.log(this.service);
                this.addedContactOnLoad();
            },
        });

    </script>
@endsection