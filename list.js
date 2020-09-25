"use strict";
// Class definition

var KTUserListDatatable = function () {

    // variables
    var datatable;

    // init
    var init = function () {
        // init the datatables. Learn more: https://keenthemes.com/metronic/?page=docs&section=datatable
        datatable = $('#kt_apps_user_list_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
                        url: '/admin/area/getAreaList',
                    },
                },
                pageSize: 10, // display 20 records per page
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#generalSearch'),
                delay: 400,
            },

            // columns definition
            columns: [{
                    field: "id",
                    title: "ID",

                    // callback function support for column rendering
                }, {
                    field: 'top_option_text',
                    title: '街道名称',

                }, {
                    field: 'option_text',
                    title: '社区名称',

                }, {
                    field: 'description',
                    title: '社区简介',
                }, {
                    field: 'population',
                    title: '人口数',
                }, {
                    field: "family",
                    title: "家庭数",
                    width: 'auto',
                    autoHide: false,
                    // callback function support for column rendering
                }, {
                    field: "form_wuhan_count",
                    title: "来自武汉",
                    width: 100,
                    
                }, {
                    field: "contact_hubei_count",
                    title: "接触过湖北人",
                    width: 100,

                }, {
                    field: "contact_patient_count",
                    title: "接触患者",
                    width: 100,
                }, {
                    field: "is_fever_count",
                    title: "是否发烧",
                }, {
                    width: 110,
                    field: 'remark',
                    title: '备注',
                }, {
                    field: "action",
                    width: 80,
                    title: "操作",
                    sortable: false,
                    autoHide: false,
                    overflow: 'visible',
                    template: function (row) {
                        return '\
							<div class="dropdown">\
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown">\
									<i class="flaticon-more-1"></i>\
								</a>\
								<div class="dropdown-menu dropdown-menu-right">\
									<ul class="kt-nav">\
										<li class="kt-nav__item">\
											<a href="/investigationInfo/' + row.id + '" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-expand"></i>\
												<span class="kt-nav__link-text">查看</span>\
											</a>\
										</li>\
										<li class="kt-nav__item">\
											<a href="#" class="kt-nav__link">\
												<i class="kt-nav__link-icon flaticon2-contract"></i>\
												<span class="kt-nav__link-text">编辑</span>\
											</a>\
										</li>\
									</ul>\
								</div>\
							</div>\
						';
                    },
                }]
        });
    }

    // search
    var search = function () {
        $('#search').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'key');
        });


    }



    return {
        // public functions
        init: function () {
            init();
            search();

        },
    };
}();

// On document ready
KTUtil.ready(function () {
    KTUserListDatatable.init();
});
