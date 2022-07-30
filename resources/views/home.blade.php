@extends('layouts.app')

@section('content')
<div class="content content-fixed bd-b">
    <div class="hidden alert-dismissible mg-b-0 fade show" id="success-aler" role="alert">
        <strong id="messages_content"></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
      <div class="d-sm-flex align-items-center justify-content-between">
        
        <div class="mg-t-20 mg-sm-t-0">
          <a href="#upload_file_modal" class="btn btn-primary mg-l-5" data-toggle="modal" data-animation="effect-flip-vertical"><i data-feather="upload-cloud" class="mg-r-5"></i> Upload File</a>
        </div>
        <div>
          <h4 id="tot_file_size" class="mg-b-5"></h4><span>Total uploads size</span>
        </div>
      </div>
    </div><!-- container -->
</div><!-- content -->

<div class="content tx-13">
    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <table id="file_table" style="width: 100%" class="table">
                <thead>
                <tr>
                    <th class="wd-5p">ID</th>
                    <th class="wd-10p">Name</th>
                    <th class="wd-10p">Note</th>
                    <th class="wd-5p">Size</th>
                    <th class="wd-10p">Upload Date</th>
                    <th class="wd-10p">Action</th>
                </tr>
                </thead>
            </table>
    </div><!-- container -->
</div><!-- content -->

<!-- modal for user to upload a file -->
<div class="modal fade" id="upload_file_modal" tabindex="-1" role="dialog" aria-labelledby="fileUploadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
        <div class="modal-header">
            <h6 class="modal-title" id="fileUploadLabel">Upload your file(s)</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" id="upload_file_form" enctype="multipart/form-data">
        <div class="modal-body">
            
            @csrf
            <div class="form-group col">
                <div class="row">
                <div class="col-6">
                    <label for="file_note" class="mg-b-0 col-form-label tx-semibold text-md-right text-white">{{ __('Note') }} <span class="tx-danger">*</span></label>
                    <p class="mg-b-0 text-info"><strong>Max characters: 1000</strong></p>
                    <textarea id="file_note" placeholder="Brief notes" class="form-control text-white" name="file_note" rows="5" cols="10"></textarea>
                </div>
                <!-- <input type="hidden" id="file_id" name="file_id"> -->

                <div class="col-6">
                    <label for="upload_file" class="mg-b-0 col-form-label tx-semibold text-md-right text-white">{{ __('Select your file') }} <span class="tx-danger">*</span></label>
                    <p class="mg-b-0 text-info"><strong>Max Size: 8MB | Up to 5 uploads at once</strong></p>
                    <input id="upload_files" type="file" class="form-control text-white" name="upload_files[]" multiple >
                </div>

                </div><!-- row -->
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
            <button type="submit" name="form_upload_btn" id="form_upload_btn" class="btn btn-primary tx-13">Save</button>
        </div>
        </form>
        </div>
    </div>
</div>

<!-- modal for user to edit file note -->
<div class="modal fade" id="edit_note_modal" tabindex="-1" role="dialog" aria-labelledby="editFileNoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content tx-14">
        <div class="modal-header">
            <h6 class="modal-title" id="editFileNoteLabel">Edit file note</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" id="edit_file_note_form">
        <div class="modal-body">
            
            @csrf
            <div class="form-group col">
                <div class="row">
                <div class="col-12">
                    <label for="edit_file_note" class="mg-b-0 col-form-label tx-semibold text-md-right text-white">{{ __('Note') }} <span class="tx-danger">*</span></label>
                    <p class="mg-b-0 text-info"><strong>Max characters: 1000</strong></p>
                    <textarea id="edit_file_note" placeholder="Brief notes" class="form-control text-white" name="edit_file_note" rows="5" cols="10"></textarea>
                </div>
                <input type="hidden" id="edit_file_id" name="edit_file_id">

                </div><!-- row -->
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
            <button type="submit" name="edit_note_btn" id="edit_note_btn" class="btn btn-primary tx-13">Save Edit</button>
        </div>
        </form>
        </div>
    </div>
</div>
@endsection
