/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//csrf token
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

var mFileId = 0;

var mIsAlertOn = false;

// var numOfFiles = checkNumOfFiles();
    // if(numOfFiles > 5){
    //     mIsAlertOn = true;

    //     $('#custom-alert').addClass('custom-alert');
    //     $('#alert-msg').html("<i class='fas fa-x'></i> Attempt to upload "+numOfFiles+" at once. Only 5 at once accepted.");
    //     $('#custom-alert').show();
    // }


//handle file upload
$('#form_upload_btn').on('click', function (e) {
    e.preventDefault();
    var bigFiles = checkFileSize();
    

    if (bigFiles > 0){
        mIsAlertOn = true;

        $('#custom-alert').addClass('custom-alert');
        $('#alert-msg').html("<i class='fas fa-x'></i> "+bigFiles+" file(s) are above the 8MB limit. Please check them out and try again");
        $('#custom-alert').show();
    }else{

        // Get form
        var form = $("#upload_file_form")[0];

        // Create an FormData object
        var data = new FormData(form);
        
        // disable the submit button
        $("#form_upload_btn").prop("disabled", true);
        
        $.ajax({
            url: "/upload-file",
            enctype: "multipart/form-data",
            type: 'post',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () { // show loading spinner
                $('#loader').removeClass('hidden');
            },
            //dataType: 'json',
            data: data,
            success: function(data) {
                console.log(data);
                $("#form_upload_btn").prop("disabled", false);
                if(data.success){
                    mIsAlertOn = true;
                    $('#custom-alert').addClass('custom-alert success');
                    $('#alert-msg').html("<i class='fas fa-check-circle'></i> "+data.success);
                    $('#custom-alert').show();

                    getAllFiles();
                    document.getElementById("upload_file_form").reset();
                    $("#upload_file_modal").modal("hide");
                }

                if(data.error){
                    mIsAlertOn = true;

                    $('#custom-alert').addClass('custom-alert');
                    $('#alert-msg').html("<i class='fas fa-x'></i> "+data.error);
                    $('#custom-alert').show();
                }

                if(data.info){
                    mIsAlertOn = true;

                    $('#custom-alert').addClass('custom-alert warning');
                    $('#alert-msg').html("<i class='fas fa-info-circle'></i> "+data.info);
                    $('#custom-alert').show();
                }
            },
            error: function (e) {
                let responseHtml = '';
                var errors = e.responseJSON.errors;
                
                $.each( errors , function( key, value ) {
                    responseHtml = '<p> * ' + value + '</p>';
                });

                mIsAlertOn = true;

                $('#custom-alert').addClass('custom-alert');
                $('#alert-msg').html("<i class='fas fa-x'></i> "+responseHtml);
                $('#custom-alert').show();

            $("#form_upload_btn").prop("disabled", false);
            },
            complete: function () { // hiding the spinner.
                $('#loader').addClass('hidden');
            }
        });
    }
    
    //hide the alert
setTimeout(function() {
    if(mIsAlertOn === true){
        $('#custom-alert').fadeOut('fast');
        $('#custom-alert').removeClass('custom-alert info');
        $('#custom-alert').removeClass('custom-alert warning');
        $('#custom-alert').removeClass('custom-alert success');
        $('#custom-alert').removeClass('custom-alert');
    }
    mIsAlertOn = false;
}, 5000); // <-- time in milliseconds
    
});

//get all th e user's files
function getAllFiles(){
        
    if ($.fn.DataTable.isDataTable('#file_table')) {
        $('#file_table').DataTable().destroy();
    }
    $('#file_table tbody').empty();
    $('#file_table').DataTable({
        //responsive: true,
        processing: true,
        serverSide: true,
        scrollX: true,
        order: [],
        ajax: {
            url: "/all-files",
            dataSrc: function (json) {
              var return_data = new Array();
              for(var i=0;i< json.data.length; i++){
                return_data.push({
                    id: json.data[i].id,
                    file_data: json.data[i].file_data,
                    note: json.data[i].note,
                    file_size: formatBytes(json.data[i].file_size),
                    created_at: formatDate(json.data[i].created_at),
                    action: json.data[i].action
                });
                
              }
              return return_data;
            }
         },
        columns: [
            {data: 'id'},
            {data: 'file_data'},
            {data: 'note', orderable: false, searchable: false},
            {data: 'file_size'},
            {data: 'created_at'},
            {data: 'action', orderable: false, searchable: false}
        ]
    });

    getTotalSizeOfUploads();
}

getAllFiles();

//total size of all the user's uploads
function getTotalSizeOfUploads(){
    var size = 0;
    $.get("/get-all-files-size", function(data) {
        //console.log(formatBytes(data.total_size));
        size = formatBytes(data.total_size);
        $('#tot_file_size').html(size);
        //document.getElementById("tot_file_size").value = size;
    });
}


//format the date
function formatDate(dateToFormat){
    var date = new Date(dateToFormat);
    return date.toLocaleDateString("en-GB",{day: "numeric", month: "short",year: "numeric"});
}

//convert the file size to readable size
function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function convertBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    //return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm));
}

//check the file size
function checkFileSize(){
    var numAboveSize = 0;
    var numOfFiles = 0;

    // if (!window.FileReader) { // This is VERY unlikely, browser support is near-universal
    //     console.log("The file API isn't supported on this browser yet.");
    //     return;
    // }

    var input = document.getElementById('upload_files');
    if (!input.files) { // This is VERY unlikely, browser support is near-universal
        console.error("This browser doesn't seem to support the `files` property of file inputs.");
    } else if (!input.files[0]) {
        console.log("Please select a file before clicking 'Load'");
    } else {
        
        for (var i = 0; i < input.files.length; i++) {
            numOfFiles ++;
            if(input.files[i].size > 8000000){
                numAboveSize ++;
            }
            //console.log("File " + input.files[i].name + " is " + formatBytes(input.files[i].size) + " in size");
          }
          return numAboveSize;
    }

    return 0;
}

//check number of files selected
function checkNumOfFiles(){
    var input = document.getElementById('upload_files');

    return input.files.length;
}

//download a file
function onDownloadFileClick(file_id){
    //console.log("called to donwload");
    $.ajax({
        url: "/download-file/"+file_id,
        type: 'get',
        beforeSend: function () { // show loading spinner
            $('#loader').removeClass('hidden');
        },
        success: function(data) {

            if(data.error){
                mIsAlertOn = true;

                $('#custom-alert').addClass('custom-alert');
                $('#alert-msg').html("<i class='fas fa-x'></i> "+data.error);
                $('#custom-alert').show();
            }

            if(data.length > 0 || data !== null){
                window.location = "/download-file/"+file_id;
            }

        },
        complete: function () { // hiding the spinner.
            $('#loader').addClass('hidden');
        }
    });

     //hide the alert
     setTimeout(function() {
        if(mIsAlertOn === true){
            $('#custom-alert').fadeOut('fast');
            $('#custom-alert').removeClass('custom-alert info');
            $('#custom-alert').removeClass('custom-alert warning');
            $('#custom-alert').removeClass('custom-alert success');
            $('#custom-alert').removeClass('custom-alert');
        }
        mIsAlertOn = false;
    }, 5000); // <-- time in milliseconds
}

//deleting a file
function onDeleteFileClick(file_id){
    $.ajax({
        url: "/delete-file",
        type: 'post',
        beforeSend: function () { // show loading spinner
            $('#loader').removeClass('hidden');
        },
        //dataType: 'json',
        data: {
            _token: CSRF_TOKEN,
            file_id: file_id
        },
        success: function(data) {
            //console.log(data);
            if(data.success){
                //show the draft requisitions
                getAllFiles();

                mIsAlertOn = true;

                $('#custom-alert').addClass('custom-alert success');
                $('#alert-msg').html("<i class='fas fa-check-circle'></i> "+data.success);
                $('#custom-alert').show();
                
            }
            
            if(data.error){
                mIsAlertOn = true;

                $('#custom-alert').addClass('custom-alert');
                $('#alert-msg').html("<i class='fas fa-times-circle'></i> "+data.error);
                $('#custom-alert').show();
            }
            
        },
        complete: function () { // hiding the spinner.
            $('#loader').addClass('hidden');
        }
    });
    
    //hide the alert
    setTimeout(function() {
        if(mIsAlertOn === true){
            $('#custom-alert').fadeOut('fast');
            $('#custom-alert').removeClass('custom-alert info');
            $('#custom-alert').removeClass('custom-alert warning');
            $('#custom-alert').removeClass('custom-alert success');
            $('#custom-alert').removeClass('custom-alert');
        }
        mIsAlertOn = false;
    }, 5000); // <-- time in milliseconds
}

//show modal to confirm delete of budget item
function onEditFileClick(fileId){

    $.get("/get-single-file/"+fileId, function(data) {
        $("#editFileNoteLabel").html( "Editing note for: <strong> "+ data.file_data +"</strong>" );
        $("#edit_file_id").val(fileId);
        $("#edit_file_note").html( data.note );
        $("#edit_note_modal").modal("show");
    });
    
}

//handle file upload
$('#edit_note_btn').on('click', function (e) {
    e.preventDefault();

    // Get form
    var form = $("#edit_file_note_form")[0];

    // Create an FormData object
    var data = new FormData(form);

    var fileId = document.getElementById("edit_file_id").value;
    //var fileId = $("#edit_file_id").val();
    data.append("edit_file_id", fileId);
    
    // disable the submit button
    $("#edit_note_btn").prop("disabled", true);
    
    $.ajax({
        url: "/edit-file-note",
        type: 'post',
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () { // show loading spinner
            $('#loader').removeClass('hidden');
        },
        //dataType: 'json',
        data: data,
        success: function(data) {
            //console.log(data);
            $("#edit_note_btn").prop("disabled", false);
            if(data.success){
                getAllFiles();
                document.getElementById("edit_file_note_form").reset();
                $("#edit_note_modal").modal("hide");
                
                mIsAlertOn = true;
                $('#custom-alert').addClass('custom-alert success');
                $('#alert-msg').html("<i class='fas fa-check-circle'></i> "+data.success);
                $('#custom-alert').show();
            }

            if(data.error){
                mIsAlertOn = true;

                $('#custom-alert').addClass('custom-alert');
                $('#alert-msg').html("<i class='fas fa-x'></i> "+data.error);
                $('#custom-alert').show();
            }

            if(data.info){
                mIsAlertOn = true;

                $('#custom-alert').addClass('custom-alert warning');
                $('#alert-msg').html("<i class='fas fa-info-circle'></i> "+data.info);
                $('#custom-alert').show();
            }
        },
        error: function (e) {
            let responseHtml = '';
            var errors = e.responseJSON.errors;
            
            $.each( errors , function( key, value ) {
                responseHtml = '<p> * ' + value + '</p>';
            });

            mIsAlertOn = true;

            $('#custom-alert').addClass('custom-alert');
            $('#alert-msg').html("<i class='fas fa-x'></i> "+responseHtml);
            $('#custom-alert').show();

          $("#edit_note_btn").prop("disabled", false);
        },
        complete: function () { // hiding the spinner.
            $('#loader').addClass('hidden');
        }
    });
    
    //hide the alert
    setTimeout(function() {
        if(mIsAlertOn === true){
            $('#custom-alert').fadeOut('fast');
            $('#custom-alert').removeClass('custom-alert info');
            $('#custom-alert').removeClass('custom-alert warning');
            $('#custom-alert').removeClass('custom-alert success');
            $('#custom-alert').removeClass('custom-alert');
        }
        mIsAlertOn = false;
    }, 5000); // <-- time in milliseconds
    
});

var close = document.getElementsByClassName("closebtn");
//var i;

for (var i = 0; i < close.length; i++) {
  close[i].onclick = function(){
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function(){ div.style.display = "none"; }, 600);
  };
}