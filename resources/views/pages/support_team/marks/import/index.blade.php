@extends('layouts.master')
@section('page_title', 'Import Exam Marks')
@section('content')
<div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><i class="icon-books mr-2"></i> Import Exam Marks</h5>
            {!! Qs::getPanelOptions() !!}
        </div>
        <div class="card-body">
        <form method="post" action="{{ route('marks.selector') }}">
        @csrf
        <div class="row">
            <div class="col-md-10">
                <fieldset>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exam_id" class="col-form-label font-weight-bold">Exam:</label>
                                <select required id="exam_id" name="exam_id" data-placeholder="Select Exam" class="form-control select">
                                    @foreach($exams as $ex)
                                        <option value="{{ $ex->id }}">{{ $ex->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_class_id" class="col-form-label font-weight-bold">Class:</label>
                                <select required onchange="getClassSubjects(this.value)" id="my_class_id" name="my_class_id" class="form-control select">
                                    <option value="">Select Class</option>
                                    @foreach($my_classes as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="form-group">
                        		<label for="file_uploader" class="col-form label font-weight-bold">Upload File:</label>
                        		<input type="file" id="file_uploader" class="form-control form-input-styled">
                        	</div>
                        </div>
                        
        			</div>
		
				</fieldset>
			</div>
		</div>
        <div class="row">
            <table class="col-3 table tableforContact" id="contactinformation">
              <thead>
                <tr>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
		</form>
		</div>
	</div>
	<script>
		$("#file_uploader").change(function() {

          console.log('changed')

          var uploader = $("#file_uploader");
          var data = new FormData()
          data.append('file', uploader[0].files[0]);
          data.append('_token',$('meta[name="csrf-token"]').attr('content'))

          $.ajax({
             processData: false,
             contentType: false,
             type: 'POST',
             headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             dataType: 'json',
             data: data,
             url: '{{ route('marks.upload_excel')}}',
             success: function(data){

                console.log(Object.keys(data))
                var xxx = Object.keys(data).reduce((a, b) => data[a] > data[b] ? a : b);
                makeTableFromExcel(data[xxx])
                             
             }

          })
       })


        function makeTableFromExcel(data)
        {
            const table = document.querySelector("#contactinformation");
            const headers = table.querySelector("thead tr");
            const body = table.querySelector("tbody");
            const input = '<input type="input" id="submit" value="Submit" class="form-control">';
            const button = '<input tupe="button" value="submit" class="btn_success">';
                                
            // Create headers
            for (const key in data[xxx]) {
              const header = document.createElement("th");
              header.innerText = key;
              headers.append(header);
            }

            // Create tbody rows
            data.forEach(obj => {
              // Create row
              const row = document.createElement("tr");
              body.append(row);
              
              // Create row element
              for (const key in obj) {
                const value = document.createElement("td");

                value.innerText = obj[key];
                row.append(value,input,button);
              }
            });
        }


	</script>
    <style>
        
    </style>
	@endsection


