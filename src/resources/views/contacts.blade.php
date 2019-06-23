@extends('layouts.tabler')
@section('body_content_header_extras')

@endsection

@section('body_content_main')

@include('layouts.blocks.tabler.alert')

<div class="row">
    @include('layouts.blocks.tabler.sub-menu')

    <div class="col-md-9 col-xl-9">
        <div class="row row-cards row-deck" id="marketplace-list">

            <div id="marketplace-contacts">
                <div class="row col-md-12" v-if="contacts.length > 0 && !is_fetching">
                    <div class="col-md-6" v-for="(contact, index) in contacts" :key="contact.id">
                        <div class="card">
                        	<div class="card-status bg-blue"></div>
                        	<div class="card-header">
                        		<h3 class="card-title">@{{ typeof contact.contactable !== null ? contact.contactable.data.firstname + ' ' + contact.contactable.data.lastname : contact.firstname + ' ' + contact.lastname }}</h3>
                        	</div>
                            <div class="card-body">
                                <h5>@{{ typeof contact.contactable !== null ? contact.contactable.data.email : contact.email }}</h5>
                                <p>@{{ typeof contact.contactable !== null ? contact.contactable.data.phone : contact.phone }}</p>
    	                        <div v-if="typeof contact.contactable !== 'undefined' && typeof contact.contactable.data.professional_services !== 'undefined' && contact.contactable.data.professional_services.data.length  > 0">
    	                            <ul class="">
    	                                <li v-for="service in contact.contactable.data.professional_services.data" :key="service.id">
    	                                    @{{ service.title }} @ @{{ service.cost_currency + service.cost_amount.formatted + (service.cost_frequency === 'standard' ? '' : '/' + service.cost_frequency) }} &nbsp; <a v-bind:href="'/mmp/marketplace-services/' + service.id">View</a>
    	                                </li>
    	                            </ul>
    	                        </div>
                            </div>
                            <div class="card-footer">
                                <!-- <a class="btn btn-primary btn-sm" href="#" v-if="typeof contact.contactable !== 'undefined' && typeof contact.contactable.data.professional_services !== 'undefined' && contact.contactable.data.professional_services.data.length  > 0">Services</a>
                                &nbsp; -->
                                <!-- <a class="btn btn-success btn-sm" v-bind:href="'{{ route('directory.vendors') }}/' + contact.id">Send Payment</a>
                                &nbsp; -->
                                <a class="btn btn-danger btn-sm" href="#" v-on:click.prevent="deleteContact(index)">Remove</a>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12" v-if="typeof meta.pagination !== 'undefined' && meta.pagination.total_pages > 1">
                        <!--TODO: Handle situations where the number of pages > 10; we need to limit the pages displayed in those cases -->
                        <ul class="pagination justify-content-end">
    						<!--TODO: Handle situations where the number of pages > 10; we need to limit the pages displayed in those cases -->
    						<li class="page-item"><a class="page-link" href="#!" v-on:click.prevent="changePage(1)">First</a></li>
    						<li class="page-item" v-for="n in meta.pagination.total_pages" v-bind:class="{active: n === page_number}">
    						    <a class="page-link" href="#" v-on:click.prevent="changePage(n)" v-if="n !== page_number">@{{ n }}</a>
    						    <a class="page-link" href="#" v-else>@{{ n }}</a>
    						</li>
    						<li class="page-item"><a class="page-link" href="#!" v-on:click.prevent="changePage(meta.pagination.total_pages)">Last</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-12" v-if="contacts.length === 0 && !is_fetching">
                @component('layouts.blocks.tabler.empty-fullpage')
                    @slot('title')
                        No Contacts
                    @endslot
                    <strong>Service Professionals</strong> &amp; <strong>Product Vendors</strong> that you patronize appear here to make it easier to buy from them again
                    @slot('buttons')
                        <a href="{{ route('marketplace-services') }}" class="btn btn-indigo btn-sm">Buy Services</a>
                        &nbsp;
                        <a href="{{ route('marketplace-products') }}" class="btn btn-cyan btn-sm">Buy Products</a>
                    @endslot
                @endcomponent
                </div>


                <div class="col-md-12" v-if="is_fetching">
                    <div class="loader"></div>
                    <div>Loading Contacts</div>
                </div>


            </div>

        </div>

    </div>

</div>

@endsection

@section('body_js')
    <script type="text/javascript">
        new Vue({
            el: '#marketplace-contacts',
            data: {
                is_loading: true,
                categories: {!! json_encode(!empty($categories) ? $categories : []) !!},
                isVendorMode: {!! json_encode(!empty($vendorMode)) !!},
                contacts: [],
                is_fetching: false,
                search_term: '',
                page_number: 1,
                meta: []
            },
            methods: {
                changePage: function (number) {
                    this.page_number = parseInt(number, 10);
                    this.searchContacts();
                },
                deleteContact: function (index) {
                    var contact = typeof this.contacts[index] !== 'undefined' ? this.contacts[index] : null;
                    if (contact === null) {
                        return;
                    }
                    var context = this;
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You are about to remove this contact.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, continue!",
		                showLoaderOnConfirm: true,
		                preConfirm: (delete_contact) => {
		                this.deleting = true;
                        return axios.delete("/mmp/marketplace-contacts/" + contact.id)
                            .then(function (response) {
                               // console.log(response);
                                context.contacts.splice(index, 1);
                                return swal("Deleted!", "The contact was successfully removed.", "success");
                            })
                            .catch(function (error) {
                                var message = '';
                                console.log(error);
                                if (error.response) {
                                    // The request was made and the server responded with a status code
                                    // that falls out of the range of 2xx
                                    //var e = error.response.data.errors[0];
                                    //message = e.title;
		                            var e = error.response;
		                            message = e.data.message;
                                } else if (error.request) {
                                    // The request was made but no response was received
                                    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                                    // http.ClientRequest in node.js
                                    message = 'The request was made but no response was received';
                                } else {
                                    // Something happened in setting up the request that triggered an Error
                                    message = error.message;
                                }
                                return swal("Delete Failed", message, "warning");
                            });
		                },
		                allowOutsideClick: () => !Swal.isLoading()
		            });

                },
                searchContacts: function () {
                    var context = this;
                    this.is_fetching = true;
                    this.products = [];
                    axios.get("/mmp/marketplace-contacts", {
                        params: {
                            search: context.search_term,
                            limit: 12,
                            page: context.page_number
                        }
                    }).then(function (response) {
                        context.is_fetching = false;
                        context.contacts = response.data.rows;
                        context.meta = response.data.meta;
                    }).catch(function (error) {
                        var message = '';
                        context.is_fetching = false;
                        if (error.response) {
                            // The request was made and the server responded with a status code
                            // that falls out of the range of 2xx
                            //var e = error.response.data.errors[0];
                            //message = e.title;
                            var e = error.response;
                            message = e.data.message;
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            message = 'The request was made but no response was received';
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            message = error.message;
                        }
                        return swal("Oops!", message, "warning");
                    });
                }
            },
            mounted: function () {
                this.searchContacts();
            }
        });
    </script>
@endsection