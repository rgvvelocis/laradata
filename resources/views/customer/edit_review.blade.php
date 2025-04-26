@extends('customer.layouts.app')
@section('title', $title)
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Review</h4> 
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">			  

                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Edit Review</h4>

                </div>

                <div class="card-body">
                    <div class="live-preview">
					<div class="row">
					<div class="col-xxl-3 col-md-2">&nbsp;</div>
						<div class="col-xxl-3 col-md-8">
				@if($finalSubmissionData == 0)
					{!! Form::model($getdata, ['method' => 'PATCH','route' => ['customer.updateReview', Crypt::encrypt($getdata->customerStoreData->id)]]) !!}
					<input type="hidden" name="record_id" value="{{$getdata->sr_no}}" id="record_id" >
                    <input type="hidden" id="formNo" name="forn_no" value="{{$getdata->data_form_id}}">
					<input type="hidden" id="edit_id" name="edit_id" value="{{$getdata->customerStoreData->id}}">
					 <input name="page" type="hidden" value="{{ $page}}" />
				@endif
					<div class="row gy-2">
						<div class="col-xxl-3 col-md-12">
							<div>
								<img style="width: 100%;" src="{{asset('public/admin/data_image/'.$getdata->customerAssignData->create_image)}}">
							</div>
						</div>
						<!--end col-->
					  
						<div class="col-xxl-3 col-md-12">
							<div>
								<label for="labelDuration" class="form-label">{{ __('How would you rate it?') }} *</label>
								
								<div dir="ltr">
									<div id="rater-onhover" class="align-middle"></div>
									<span class="ratingnum badge bg-info align-middle ms-2"></span>
									<input type="hidden" name="product_rate" id="product_rate" value="{{getWordsInNumber($getdata->customerStoreData->product_rate)}}" />
								</div>
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-12">
							<div>
								<label for="labeltotal_forms" class="form-label">{{ __('Title your review') }} *</label>
								{!! Form::text('review_title', $getdata->customerStoreData->review_title, array('id'=>'review_title','placeholder' => 'Review Title','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-3 col-md-12">
							<div>
								<label for="labelmin_accuracy" class="form-label">{{ __('Write your review') }} *</label>
								{!! Form::text('review', $getdata->customerStoreData->review, array('id'=>'text_review','placeholder' => 'Review','class' => 'form-control','required' => 'required')) !!}
							</div>
						</div>
						<!--end col-->
						 
						 
						 
						 <div class="col-xxl-3 col-md-6 pt-4">
							@if($finalSubmissionData == 0)
								<button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
							@else
								<button type="button" class="btn btn-danger">{{ __('Not Allowed') }}</button>							
							@endif
						</div>
						 
						<!--end col-->
						 
					</div>
					@if($finalSubmissionData == 0)
					{!! Form::close() !!}
					@endif
					 </div>
					 <div class="col-xxl-3 col-md-2">&nbsp;</div>
                </div>
				</div>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- container-fluid -->
@endsection
@section('script')
<script src="{{ asset('public/assets/js/pages/rater-js-index.js')}}"></script>
 
<script>
 document.querySelector("#rater-onhover") &&
        (starRatinghover = raterJs({
            starSize: 22,
            //rating: Number({{$getdata->customerStoreData->product_rate}}),
            rating: Number({{getWordsInNumber($getdata->customerStoreData->product_rate)}}),
            element: document.querySelector("#rater-onhover"),
            rateCallback: function (e, t) {
                this.setRating(e), t();
				$('#product_rate').val(e);
            },
            onHover: function (e, t) {
                document.querySelector(".ratingnum").textContent = e;
            },
            onLeave: function (e, t) {
                document.querySelector(".ratingnum").textContent = t;
            },
        }))
    function isNameOnly(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 65 || charCode > 122 || charCode == 91 || charCode == 93 || charCode == 94 || charCode == 95 || charCode == 92))
            return false;
        return true;
    }

    function isNumberOnly(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 47 || charCode > 57))
            return false;
        return true;
    }

    $(document).ready(function () {
        $('#review_title,#text_review,#mobile_no,#company_name,#website,#address,#office_contact,#email,#whatsapp').bind("cut copy paste", function (e) {
            e.preventDefault();
            alert('Cut, Copy & Paste not Allowed!!');
        });

    });

    
</script>
@endsection
