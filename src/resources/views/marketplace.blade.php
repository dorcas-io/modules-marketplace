@extends('layouts.tabler')
@section('body_content_header_extras')

@endsection

@section('body_content_main')

@include('layouts.blocks.tabler.alert')

<div class="row">
    @include('layouts.blocks.tabler.sub-menu')

    <div class="col-md-9 col-xl-9">
        <div class="row row-cards row-deck" id="marketplace-list">

            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter bootstrap-table"
                           data-pagination="true"
                           data-search="false"
                           data-side-pagination="server"
                           data-show-refresh="true"
                           data-unique-id="id"
                           data-id-field="id"
                           data-row-attributes="formatDirectory"
                           data-url="{{ route('marketplace-search') }}?{{ http_build_query($query) }}"
                           data-page-list="[10,25,50,100,200,300,500]"
                           data-sort-class="sortable"
                           data-search-on-enter-key="false"
                            id="marketplace-table"
                       v-on:click="clicked($event)">
                        <thead>
                        <tr>

		                    <th data-field="title">{{ empty($vendorMode) ? 'Service' : 'Product' }}</th>
		                    <th data-field="provider">Provider</th>
		                    <th data-field="provider_verified">Verified</th>
		                    <th data-field="cost_type">Type</th>
		                    <th data-field="cost">Cost</th>
		                    <th data-field="category_list">Categories</th>
		                    <th data-field="buttons">&nbsp;</th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@section('body_js')
<script>

	String.prototype.title_case = function () {
	    this.toLowerCase();
	    var components = this.split(' ');
	    return components.map(function (component) {
	        return component.charAt(0).toUpperCase() + component.substr(1).toLowerCase();
	    }).join(' ');
	};

    let vmPage = new Vue({
        el: '#marketplace-list',
        data: {
            is_loading: true,
            categories: {!! json_encode(!empty($categories) ? $categories : []) !!},
            isVendorMode: {!! json_encode(!empty($vendorMode)) !!}
        },
        computed: {

        },
        mounted: function () {
           //this.triggerEdit();
       },
       methods: {
	        titleCase: function (string) {
	            return v.titleCase(string);
	        },
	        clicked: function ($event) {
	            let target = $event.target;
	            if (!target.hasAttribute('data-action')) {
	                target = target.parentNode.hasAttribute('data-action') ? target.parentNode : target;
	            }
	            //console.log(target, target.getAttribute('data-action'));
	            let action = target.getAttribute('data-action').toLowerCase();
	            let name = target.getAttribute('data-name');
	            let id = target.getAttribute('data-id');
	            let index = parseInt(target.getAttribute('data-index'), 10);
	            if (isNaN(index)) {
	                console.log('Index is not set.');
	                return;
	            }
	            if (action === 'view') {
	                return true;
	            } else {
	                return true;
	            }
	        },
            triggerEdit: function () {
                if (this.request_id.length === 0 || this.caccounts.length === 0) {
                    return '';
                }
                let indexOf = -1;
                let totalCount = this.caccounts.length;
                for (let i = 0; i < totalCount; i++) {
                    if (this.caccount[i].id !== this.request_id) {
                        continue;
                    }
                    indexOf = i;
                    break;
                }
                if (indexOf === -1) {
                    return '';
                }
                this.editItem(indexOf);
            }
        }

    });

    /*function processRecords(response) {
        //console.log(response);
        vmPage.caccounts = response.rows;
        vmPage.triggerEdit();
        return response;
    }*/

    function formatDirectory (row, index) {
        if (row.cost_type === 'free') {
            row.cost = 'FREE';
        } else {
            row.cost = row.cost_currency + row.cost_amount.formatted;
        }
        if (row.cost_type !== 'free' && row.cost_frequency !== 'standard') {
            row.cost += ' /' + row.cost_frequency;
        }
        var categories = [];
        if (typeof row.user !== 'undefined' && typeof row.user.data.is_professional_verified !== 'undefined') {
            let is_verified = row.user.data.is_professional_verified;
            row.provider_verified = '<span class="tag ' + (is_verified ? 'tag-green' : '') + '">'+ (is_verified ? 'Verified' : 'Unverified') +'</span>';
        }
        //<span class="tag tag-blue">
        for (var i = 0; i < row.categories.data.length; i++) {
            categories.push(
                '<span class="tag"><a href="/marketplace-services?category_id=' +
                row.categories.data[i].id + '">'+row.categories.data[i].name.title_case()+'</a></span>'
            );
        }
        row.category_list = categories.join('<br>');
        row.cost_type = row.cost_type.title_case();
        row.provider = '<span class="tag"><span class="tag-avatar avatar" style="background-image: url('+row.user.data.photo+')"></span>'+ row.user.data.firstname + ' ' + row.user.data.lastname +'</span>';
        row.buttons = '<a class="btn btn-icon" href="/mmp/marketplace-services/' + row.id + '"><i data-action="view" data-index="' + index + '"  class="fe fe-eye"></i> View</a>';
        return row;
    }

</script>
@endsection