@extends('layouts.backend.app')
@section('sidebarActive', $controller)

<!--begin::Vendor Stylesheets(used for this page only)-->
@push('private_css')
	<link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <!--begin::Toolbar Component-->
	@component('backend.components.toolbar', ['pages_title' => $pages_title, 'sub_menu' => null, 'sub_menu_link' => null])
	@endcomponent	

	<!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
		<!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
			<!--begin::Card-->
			<div class="card">

				<!--begin::Header Datatable Component -->
				@component('backend.components.datatable-header')
					@slot('filter_slot')
						<!--begin::Menu 1-->
						<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
							<!--begin::Header-->
							<div class="px-7 py-5">
								<div class="fs-4 text-dark fw-bold">{{ __('main.filter_options')}}</div>
							</div>
							<!--begin::Separator-->
							<div class="separator border-gray-200"></div>
							<!--begin::Content-->
							<div class="px-7 py-5">
								<!--begin::Input group-->
								<div class="mb-10">
									<!--begin::Label-->
									<label class="form-label fs-5 fw-semibold mb-3">Status:</label>
									<!--begin::Options-->
									<div class="d-flex flex-column flex-wrap fw-semibold" data-kt-docs-table-filter="status">
										<!--begin::Option-->
										<label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
											<input class="form-check-input" type="radio" name="status" value="all" checked="checked" />
											<span class="form-check-label text-gray-600">{{ __('main.all') }}</span>
										</label>
										<!--begin::Option-->
										<label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
											<input class="form-check-input" type="radio" name="status" value="0" />
											<span class="form-check-label text-gray-600">{{ __('main.active') }}</span>
										</label>
										<!--begin::Option-->
										<label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
											<input class="form-check-input" type="radio" name="status" value="1" />
											<span class="form-check-label text-gray-600">{{ __('main.non-active') }}</span>
										</label>
									</div>
								</div>
								<!--begin::Actions-->
								<div class="d-flex justify-content-end">
									<button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">{{ __('main.reset') }}</button>
									<button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-docs-table-filter="filter">{{ __('main.apply') }}</button>
								</div>
							</div>
						</div>
					@endslot
					
					@slot('button_slot')
						<!--begin::Add data-->
						@permission('room-create')
							<button type="button" class="btn btn-primary" onclick="add()">{{__('main.add_new')}}</button>
						@endpermission
					@endslot
				@endcomponent
				
				<div class="card-body pt-0">
					<!--begin::Datatable-->
					<table id="kt_datatable_server_side" class="table align-middle table-row-dashed fs-6 gy-5">
						<thead>
						<tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
							<th class="w-10px pe-2">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
									<input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_server_side .form-check-input" value="1"/>
								</div>
							</th>
							<th>{{ __('main.name') }}</th>
							<th>{{ __('main.price') }}</th>
							<th>{{ __('main.facility') }}</th>
							<th>Status</th>
							<th>{{ __('main.created_date') }}</th>
							<th>{{ __('main.updated_date') }}</th>
							<th class="text-end min-w-100px">{{__('main.action')}}</th>
						</tr>
						</thead>
						<tbody class="text-gray-600 fw-semibold">
						</tbody>
					</table>
				</div>
			</div>

			<!--begin::Modal Component-->
			@component('backend.components.form-modal', ['modal_size' => 'modal-lg', 'modal_id' => $controller])
				@section('form_modal')
					<div class="fv-row mb-7">
						<img style="display:none;" id="preview_room_asset" class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded" height="300" width="300"
						src="{{ URL::asset('images/product.png') }}" >
					</div>

					<div class="fv-row mb-7">
						<label class="d-block fw-semibold fs-6 mb-5">{{ __('main.room_image') }}</label>
						<input type="file" class="dropzone" name="asset_id">
						<div class="form-text">{{ __('main.allowed_file_types', ['value' => "png, jpg, jpeg"]) }}</div>
						<div class="text-primary">{{ __('main.info_image_pixels', ['value' => "100 x 100"]) }}</div>
					</div>

					<div class="fv-row mb-7">
						<label class="required fs-6 fw-semibold mb-2">{{ __('main.name') }}</label>
						<input type="text" class="form-control" placeholder="{{ __('main.name') }}" name="name" />
					</div>

					<div class="fv-row mb-7">
						<label class="required form-label fw-semibold">{{ __('main.room-type') }}</label>
						<div data-table-filter="room_type">
							<select name="room_type_id" class="form-select" data-dropdown-parent="#{{ $controller }}"  data-kt-select2="true" data-placeholder="{{ __('main.please_choose') }}" data-allow-clear="true">
							<option value="">{{ __('main.please_choose') }}</option>
							@foreach($room_type as $value)
								<option value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach
							</select>
						</div>
					</div>		

					<div class="fv-row mb-7">
						<label class="required fs-6 fw-semibold mb-2">{{ __('main.area') }}</label>
						<input type="number" class="form-control" placeholder="{{ __('main.area') }}" name="area" />
						<div class="text-muted mt-1">
							luas kamar dalam meter persegi (m²)
						</div>
					</div>

					<div class="fv-row mb-7">
						<label class="required fs-6 fw-semibold mb-2">{{ __('main.price') }}</label>
						<input type="number" class="form-control" placeholder="{{ __('main.price') }}" name="price" />
					</div>

					<div class="fv-row mb-7">
						<label class="form-label">{{ __('main.facility') }}</label>
						<input class="form-control" value="" placeholder="{{ __('main.facility') }}"  name="facility" id="kt_tagify"/>
						<div class="text-muted mt-1">
							ketik arah panah bawah (⇩). untuk melihat sugesti fasilitas
						</div>						
					</div>


					<div class="fv-row mb-7">
						<label class="fs-6 fw-semibold mb-2">{{ __('main.description') }}</label>
						<textarea  id="kt_docs_ckeditor_classic" class="form-control" rows="3" name="description" data-kt-autosize="true" placeholder="{{ __('main.description') }}"></textarea>
					</div>
					
					<div class="fv-row mb-7">
						<label class="fs-6 fw-semibold mb-2">Status</label>
						<div class="d-flex">
							<label class="form-check form-check-sm form-check-custom form-check-solid me-5">
							<input class="form-check-input" type="radio" value="0" id="flexCheckChecked1" name="status" checked="">
								<label class="form-check-label" for="flexCheckDefault1">
									{{ __('main.active') }}
								</label>
							</label>
							<label class="form-check form-check-sm form-check-custom form-check-solid">
								<input class="form-check-input" type="radio" value="1" id="flexCheckChecked1" name="status">
								<label class="form-check-label" for="flexCheckDefault1">
									{{ __('main.non-active') }}
								</label>
							</label>
						</div>        
					</div>
				@endsection
			@endcomponent	
		</div>
	</div>
@endsection

<!--begin::Vendors Javascript(used for this page only)-->
@push('private_js')
	<script src="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
	<script src="{{ URL::asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
	<script>
		"use strict";

		const URL_API = `{{ url('admin/rooms') }}`

		// Function definition
		function add() {
			// Reset the form
			KTModalForm.resetForm();

			// Set text
			$('#{{ $controller  }}_submit_text').text(`{{ __('main.save') }}`);
			$('#{{ $controller  }}_header_title').text(`{{ __('main.create_new') }}`);

			// Set method
			$('input[name="_method"]').val('post');

			$("#preview_room_asset").hide();

			// Show the modal
			$('#{{ $controller  }}_trigger').modal('show');
		}	

		function edit(id) {
			// Reset the form
			KTModalForm.resetForm();

			// Set text
			$('#{{ $controller  }}_submit_text').text(`{{ __('main.update') }}`);
			$('#{{ $controller  }}_header_title').text(`{{ __('main.edit_data') }}`);

			// Set method and ID values
			$('input[name="_method"]').val('put');
			$('input[name="_id"]').val(id);

			// Fetching data
			$.ajax({
				url : URL_API + '/' + id,
				type: "GET",
				dataType: "JSON",             
				success: function(response){
					if (response.status.code === 200) {
						const data = response.data;

						$('input[name="name"]').val(data.name);
						$('input[name="area"]').val(data.area);
						$('input[name="price"]').val(data.price);
						$('select[name="room_type_id"]').val(data.room_type_id).trigger('change').attr('data-placeholder', data.room_type_id);
						
						// Remove existing data from CKEditor
						ckEditorInstance.setData('');
						if(data.description != null) {
							// Set new data to CKEditor
							ckEditorInstance.setData(data.description);
							$('textarea[name="description"]').val(data.description);
						}

						var facilities = [];
						if (data.facilities.length > 0) {
							for (var i = 0; i < data.facilities.length; i++) {
								facilities.push(data.facilities[i].name);
							}
						}
						$('input[name="facility"]').val(facilities.join(', '));


						// Set Product Asset
						var path = `{{ config('app.url') }}`;
						var product_asset = path + '/images/product.png';
						if (data.assets_relative_path != null){
							product_asset = path + '/' + data.assets_relative_path; 
							$("#preview_room_asset").show();
						}						
						$("#preview_room_asset").attr('src', product_asset);

						// Set the radio button value based on the status value
						if (data.status === 0) {
							$('input[value="0"][name="status"]').prop('checked', true);
						} else {
							$('input[value="1"][name="status"]').prop('checked', true);
						}

						// Show the modal
						$('#{{ $controller  }}_trigger').modal('show');				
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					if (jqXHR.responseJSON.status.message != undefined){
						errorThrown = jqXHR.responseJSON.status.message;
					}
					ToastrError(errorThrown);
				}
			});	
		}

		// Declare the ckEditorInstance variable outside the function
		let ckEditorInstance; 
		ClassicEditor
			.create(document.querySelector('#kt_docs_ckeditor_classic'))
			.then(editor => {
				console.log(editor);

				// Store the CKEditor instance for later use
				ckEditorInstance = editor;
		
				// Handle keyup event on CKEditor
				ckEditorInstance.editing.view.document.on('keyup', () => {
					// Get the CKEditor value
					const description = ckEditorInstance.getData();
					// Set the CKEditor value to the hidden input field for submission
					$('textarea[name="description"]').val(description);
				});
			})
			.catch(error => {
				console.error(error);
		});

		// Class definition
		var KTDatatablesServerSide = function () {
			// Shared variables
			var table;
			var dt;
			var filterStatus;

			// Private functions
			var initDatatable = function () {
				dt = $("#kt_datatable_server_side").DataTable({
					searchDelay: 500,
					processing: true,
					serverSide: true,
					order: [[4, 'desc']],
					stateSave: true,
					select: {
						style: 'multi',
						selector: 'td:first-child input[type="checkbox"]',
						className: 'row-selected'
					},
					ajax: {
						url: URL_API,
					},
					columns: [
						{ data: 'id' },
						{ 
							data: 'name',
							width: '20%' 
						},
						{ data: 'price' },
						{ 
							data: 'facilities',
							width: '30%' 
						},
						{ data: 'status' },
						{ data: 'created_at' },
						{ data: 'updated_at' },
						{ data: null },
					],
					columnDefs: [
						{
							targets: 0,
							orderable: false,
							render: function (data) {
								return `
									<div class="form-check form-check-sm form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" value="${data}" />
									</div>`;
							}
						},
						{	
							targets: 1,
							createdCell: function (td, cellData, rowData, row, col) {
								$(td).addClass('d-flex align-items-center');
							},
							render: function (data, type, row) {
								var path = `{{ config('app.url') }}`;
								var room_assets = path + '/images/product.png';
								if (row.assets_relative_path != null){
									room_assets = path + '/' + row.assets_relative_path; 
								}

								var action = `onclick="edit('${row.id}')"`;
								
								var html = `<div class="symbol symbol-50px overflow-hidden me-3">
									<a href="javascript:void(0)" `+ action +`>
										<div class="symbol-label">
											<img src="`+ room_assets +`" alt="`+ row.name +`" class="w-100">
										</div>
									</a>
								</div>`;
									
								html += `<div class="d-flex flex-column">
											<a href="javascript:void(0)" `+ action +` class="text-gray-800 text-hover-primary mb-1">`+ row.name +`</a>
											<span>`+ row.room_type_name +`</span>
										</div>`;

								return html;
							}
						},
						{
							targets: 2,
							render: function (data, type, row) {
								return IDRCurrency(row.price);
							}
						},
						{
							targets: 3,
							orderable: false,
							render: function (data, type, row) {
								var facility = '';
								if (data.length > 0) {
									for (var i = 0; i < data.length; i++) {
										facility += `<span class="badge badge-secondary">${data[i].name}</span>&nbsp;&nbsp;`;
									}
								}
								return facility;
							}
						},
						{
							targets: 4,
							render: function (data) {
								var labelClass = data == 0 ? 'primary' : 'danger';
								var labelText = data == 0 ? '{{ __('main.active') }}' : '{{ __('main.non-active') }}';
								return '<span class="badge badge-' + labelClass + '">' + labelText + '</span>';
							}
						},
						{
							targets: -1,
							data: null,
							orderable: false,
							className: 'text-end',
							render: function (data, type, row) {
								return `
									<a href="javascript:void(0)" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
										{{__('main.action')}}
										<span class="svg-icon fs-5 m-0">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"></polygon>
													<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
												</g>
											</svg>
										</span>
									</a>
									<!--begin::Menu-->
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
										<!--begin::Menu item-->
										@permission('room-edit')
											<div class="menu-item px-3">
												<a href="javascript:void(0)" onclick="edit('`+ data["id"] +`')" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
													{{ __('main.edit') }}
												</a>
											</div>
										@endpermission

										<!--begin::Menu item-->
										@permission('room-delete')
											<div class="menu-item px-3">
												<a href="javascript:void(0)" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
													{{ __('main.delete') }}
												</a>
											</div>
										@endpermission

									</div>
								`;
							},
						},
					],
				});

				table = dt.$;

				// Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
				dt.on('draw', function () {
					initToggleToolbar();
					toggleToolbars();
					handleDeleteRows();
					KTMenu.createInstances();
				});
			}

			// Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
			var handleSearchDatatable = function () {
				const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
				filterSearch.addEventListener('keyup', function (e) {
					dt.search(e.target.value).draw();
				});
			}

			// Filter Datatable
			var handleFilterDatatable = () => {
				// Select filter options
				filterStatus = document.querySelectorAll('[data-kt-docs-table-filter="status"] [name="status"]');
				const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

				// Filter datatable on submit
				filterButton.addEventListener('click', function () {
					// Get filter values
					let statusValue = '';

					// Get status value
					filterStatus.forEach(r => {
						if (r.checked) {
							statusValue = r.value;
						}

						// Reset status value if "All" is selected
						if (statusValue === 'all') {
							statusValue = '';
						}
					});

					// Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
					dt.search(statusValue).draw();
				});
			}

			// Delete customer
			var handleDeleteRows = () => {
				// Select all delete buttons
				const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

				deleteButtons.forEach(d => {
					// Delete button on click
					d.addEventListener('click', function (e) {
						e.preventDefault();

						// Select parent row
						const parent = e.target.closest('tr');

						// Get data
						const id = parent.querySelector('input[type="checkbox"]').value;
						const infoField = parent.querySelectorAll('td')[1].innerText;

						if (id != undefined){
							// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
							Swal.fire({
								text: "{{ __('main.are_you_sure_want_to_delete' )}} " + infoField + "?",
								icon: "warning",
								showCancelButton: true,
								buttonsStyling: false,
								confirmButtonText: "{{ __('main.yes_deleted') }}",
								cancelButtonText: "{{ __('main.no_cancel') }}",
								customClass: {
									confirmButton: "btn fw-bold btn-danger",
									cancelButton: "btn fw-bold btn-active-light-primary"
								}
							}).then(function (result) {
								if (result.value) {
									$.ajax({
										url : URL_API + '/' + id,
										type: "DELETE",
										dataType: "JSON",
										headers: {
											'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
										},												
										success: function(response){
											if (response.status.code === 200) {
												Swal.fire({
													text: "{{ __('main.you_have_deleted') }} " + infoField + "!.",
													icon: "success",
													buttonsStyling: false,
													confirmButtonText: "Ok, got it!",
													customClass: {
														confirmButton: "btn fw-bold btn-primary",
													}
												}).then(function () {
													// delete row data from server and re-draw datatable
													dt.draw();
												});
											}
										},
										error: function (jqXHR, textStatus, errorThrown) {
											if (jqXHR.responseJSON.status.message != undefined){
												errorThrown = jqXHR.responseJSON.status.message;
											}
											SwalError(errorThrown);
										}
									});								
								} else if (result.dismiss === 'cancel') {
									SwalError(infoField + " {{ __('main.was_not_deleted') }}");
								}
							});
						}
					})
				});
			}

			// Reset Filter
			var handleResetForm = () => {
				// Select reset button
				const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');

				// Reset datatable
				resetButton.addEventListener('click', function () {
					// Reset status type
					filterStatus[0].checked = true;

					// Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
					dt.search('').draw();
				});
			}

			// Init toggle toolbar
			var initToggleToolbar = function () {
				// Toggle selected action toolbar
				// Select all checkboxes
				const container = document.querySelector('#kt_datatable_server_side');
				const checkboxes = container.querySelectorAll('[type="checkbox"]');

				// Select elements
				const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

				// Toggle delete selected toolbar
				checkboxes.forEach(c => {
					// Checkbox on click event
					c.addEventListener('click', function () {
						setTimeout(function () {
							toggleToolbars();
						}, 50);
					});
				});

				// Deleted selected rows
				deleteSelected.addEventListener('click', function () {
					// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
					var post_arr = [];
					const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');
					allCheckboxes.forEach(c => {
						if (c.checked) {
							const value = c.value;
							if (value !== undefined && value !== "" && !post_arr.includes(value)) {
								post_arr.push(value);
							}
						}
					});
					if(post_arr.length > 0){
						Swal.fire({
							text: "{{ __('main.are_you_sure_you_want_to_delete_selected_data') }}",
							icon: "warning",
							showCancelButton: true,
							buttonsStyling: false,
							showLoaderOnConfirm: true,
							confirmButtonText: "{{ __('main.yes_deleted') }}",
							cancelButtonText: "{{ __('main.no_cancel') }}",
							customClass: {
								confirmButton: "btn fw-bold btn-danger",
								cancelButton: "btn fw-bold btn-active-light-primary"
							},
						}).then(function (result) {
							if (result.value) {
								$.ajax({
									url: URL_API + '/delete/batch',
									type: 'POST',
									data: { id: post_arr},
									headers: {
										'X-HTTP-Method-Override': "POST",
										'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
									},								
									success: function(response){
										Swal.fire({
											text: "{{ __('main.you_have_deleted_all_selected_data') }}",
											icon: "success",
											buttonsStyling: false,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn fw-bold btn-primary",
											}
										}).then(function () {
											// delete row data from server and re-draw datatable
											dt.draw();
										});
									},
									error: function (jqXHR, textStatus, errorThrown) {
										if (jqXHR.responseJSON.status.message != undefined){
											errorThrown = jqXHR.responseJSON.status.message;
										}
										SwalError(errorThrown);
									}
								});
	
								// Remove header checked box
								const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
								headerCheckbox.checked = false;
	
							} else if (result.dismiss === 'cancel') {
								SwalError(`{{ __('main.selected_data_was_not_deleted') }}`);
							}
						});
					}
				});


			}

			// Toggle toolbars
			var toggleToolbars = function () {
				// Define variables
				const container = document.querySelector('#kt_datatable_server_side');
				const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
				const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
				const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

				// Select refreshed checkbox DOM elements
				const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

				// Detect checkboxes state & count
				let checkedState = false;
				let count = 0;

				// Count checked boxes
				allCheckboxes.forEach(c => {
					if (c.checked) {
						checkedState = true;
						count++;
					}
				});

				// Toggle toolbars
				if (checkedState) {
					selectedCount.innerHTML = count;
					toolbarBase.classList.add('d-none');
					toolbarSelected.classList.remove('d-none');
				} else {
					toolbarBase.classList.remove('d-none');
					toolbarSelected.classList.add('d-none');
				}
			}

			// Public methods
			return {
				init: function () {
					initDatatable();
					handleSearchDatatable();
					initToggleToolbar();
					handleFilterDatatable();
					handleDeleteRows();
					handleResetForm();
				},
				refresh: function () {
					dt.draw();
				}				
			}
		}();

		var KTModalForm = function () {
			var submitButton;
			var validator;
			var form;
			var modal;
		
			// Init form inputs
			var handleForm = function () {
				// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
				validator = FormValidation.formValidation(
					form,
					{
						fields: {
							'name': {
								validators: {
									notEmpty: {
										message: `{{ __('main.name') }} {{ __('main.is_required') }}`
									}
								}
							},
							'room_type_id': {
								validators: {
									notEmpty: {
										message: `{{ __('main.room-type') }} {{ __('main.is_required') }}`
									}
								}
							},
							'area': {
								validators: {
									notEmpty: {
										message: `{{ __('main.area') }} {{ __('main.is_required') }}`
									}
								}
							},
							'price': {
								validators: {
									notEmpty: {
										message: `{{ __('main.price') }} {{ __('main.is_required') }}`
									}
								}
							}
						},
						plugins: {
							trigger: new FormValidation.plugins.Trigger(),
							bootstrap: new FormValidation.plugins.Bootstrap5({
								rowSelector: '.fv-row',
								eleInvalidClass: '',
								eleValidClass: ''
							})
						}
					}
				);

				// Action buttons
				submitButton.addEventListener('click', function (e) {
					e.preventDefault();

					// Validate form before submit
					if (validator) {
						validator.validate().then(function (status) {
							console.log('validated!');

							if (status == 'Valid') {
								submitButton.setAttribute('data-kt-indicator', 'on');
								
								// Disable submit button whilst loading
								submitButton.disabled = true;

								// set data
								var url;
								var method = form._method.value;
								var formData = new FormData(document.querySelector('#{{ $controller  }}'));
								if (form._method.value == "post"){
									url = URL_API;
								}else if  (method == "put"){
									url = URL_API + "/" + form._id.value;
								}
								submitForm(url, method, formData);								

							} else {
								ToastrError(`{{ __('main.sorry_looks_like_there_are_some_errors_detected_please_try_again') }}`);
							}
						});
					}
				});

				// Send data to server | POST | PUT
				function submitForm(url, method, formData) {
					$.ajaxSetup({
						headers: {
							'X-HTTP-Method-Override': method
						}
					});
					$.ajax({
						url : url,
						type: "POST",
						data: formData,
						contentType: false,
						processData: false,
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},						
						dataType: "JSON",
						success: function(response){
							var messages = "{{ __('main.data_added_succesfully') }}";
							if(method.toLowerCase() == "put"){
								messages = "{{ __('main.data_succesfully_changed') }}";
							}

							submitButton.removeAttribute('data-kt-indicator');
							ToastrSuccess(messages);
							if (typeof KTDatatablesServerSide !== 'undefined') {
								KTDatatablesServerSide.refresh();
							}
							// Close the modal
							if (typeof modal !== 'undefined') {
								modal.hide();
							}
							// Enable submit button after loading
							submitButton.disabled = false;
						},
						error: function (jqXHR, textStatus, errorThrown) {
							let errorMessage = "An error occurred.";
							if (jqXHR.responseJSON && jqXHR.responseJSON.status && jqXHR.responseJSON.status.message) {
								const errorMessages = jqXHR.responseJSON.status.message;

								// Construct the error message dynamically
								const errorFields = Object.keys(errorMessages);
								if (errorFields.length > 0) {
									errorMessage = "The following errors occurred: \n";
									
									errorFields.forEach((field) => {
										errorMessage += `${field}: ${errorMessages[field]}\n`;
									});
								}
							}
							ToastrError(errorMessage);
							submitButton.removeAttribute('data-kt-indicator');
							submitButton.disabled = false;
						}
					}); 
				}									
			}

			// Reset all select and form values
			var resetForm = function () {
				form.reset();
				var selects = form.querySelectorAll('select');
				if (selects !== null && selects !== undefined) {
					selects.forEach(select => {
						$(select).val('').trigger('change');
					});
				}		
				ckEditorInstance.setData('');
			}

			return {
				// Public functions
				init: function () {
					// Elements
					modal = new bootstrap.Modal(document.querySelector('#{{ $controller  }}_trigger'));

					form = document.querySelector('#{{ $controller  }}');
					submitButton = form.querySelector('#{{ $controller  }}_submit');
					handleForm();
				},
				resetForm: resetForm 
			};
		}();

		// On document ready
		KTUtil.onDOMContentLoaded(function () {
			KTModalForm.init();
			KTDatatablesServerSide.init();

			var input = document.querySelector("#kt_tagify");
			// Make an AJAX request to retrieve the tag suggestions
			$.ajax({
				url: "{{ url('admin/facilities') }}", // Replace with your API endpoint URL
				method: "GET",
				success: function(response) {
					var data = response.data;
	
					// Extract the tag names from the response data
					var tagNames = data.map(function(item) {
						return item.name;
					});
	
					// Initialize Tagify component with the retrieved tag suggestions
					if (input) {
						new Tagify(input, {
							whitelist: tagNames,
							enforceWhitelist: true
						});
					}
	
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});
		});
	</script>
@endpush

