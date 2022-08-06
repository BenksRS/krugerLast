<div>
    <div class="card">
        <div class="card-body">


            <form action="{{ url('/employees/upload') }}"  class="dropzone">
                <div class="fallback">
                    <input name="file" multiple="multiple">
                </div>
                <div class="dz-message needsclick">
                    <div class="mb-3">
                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                    </div>

                    <h4>Drop files here or click to upload.</h4>
                </div>



                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Send Files</button>
                </div>
            </form>
        </div>

    </div>
</div>
