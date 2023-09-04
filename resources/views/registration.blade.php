@extends('base')

@section('title', 'New user')

@section('content')
<section class="h-full m-5 rounded-lg bg-slate-200 dark:bg-neutral-700">
    <div class="w-full pt-5">
        <h1 class="text-2xl font-bold text-center">Add new account</p>
    </div>

    <form action="#" method="post">
        <div class="md:mx-3 md:p-6">
            <!-- Firstname -->
            <div class="my-2">
                <label for="firstname" class="block text-sm font-medium text-gray-500">Firstname</label>
                <input type="text" name="firstname" id="firstname" class="w-full rounded-lg border-gray-300 shadow-lg" required autocomplete="off"/>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="firstname-error"></span>
            </div>

            <!-- Middlename -->
            <div class="my-2">
                <label for="middlename" class="block text-sm font-medium text-gray-500">Middlename</label>
                <input type="text" name="middlename" id="middlename" class="w-full rounded-lg border-gray-300 shadow-lg" required autocomplete="off"/>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="middlename-error"></span>
            </div>

            <!-- Lastname -->
            <div class="my-2">
                <label for="lastname" class="block text-sm font-medium text-gray-500">Lastname</label>
                <input type="text" name="firstname" id="lastname" class="w-full rounded-lg border-gray-300 shadow-lg" required autocomplete="off"/>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="lastname-error"></span>
            </div>

            <!-- Suffix -->
            <div class="my-2">
                <label for="lastname" class="block text-sm font-medium text-gray-500">Suffix</label>
                <input type="text" name="suffix" id="suffix" class="w-full rounded-lg border-gray-300 shadow-lg" required autocomplete="off"/>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="suffix-error"></span>
            </div>

            <!-- Division -->
            <div class="my-2">
                <label for="division" class="block text-sm font-medium text-gray-500">Division</label>
                <select name="division" id="division" class="w-full rounded-lg border-gray">
                    <option value="">--- Please select ---</option>
                    <option value="ord">Office of the Regional Director</option>
                    <option value="fad">Finance and Administartive Division</option>
                    <option value="gd">Geoscience Division</option>
                    <option value="mmd">Mine Management Division</option>
                    <option value="msesdd">Mine Safety, Environment and Social Development Division</option>
                </select>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="division-error"></span>
            </div>

            <button type="button" id="saveBtn" class="mt-3 px-10 py-3 rounded-full bg-green-300 font-bold hover:bg-red-600 hover:text-white">Save</button>
            <button type="reset" id="resetBtn" class="mt-3 px-10 py-3 rounded-full bg-orange-300 font-bold hover:bg-red-600 hover:text-white">Reset</button>
        </div>
    </form>
</section>
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        // Save button
        $('#saveBtn').click(function() {
            Swal.fire({
                title: 'Please wait while saving ....',
                didOpen: () => {
                    // Display loading while saving sequence in progress
                    Swal.showLoading();
                    // Make AJAX Call for save sequence
                    $.ajax({
                        url: '{{ route('registration.post') }}',
                        type: 'POST',
                        dateType: 'json',
                        data: {
                            firstname   :   $('#firstname').val(),
                            middlename  :   $('#middlename').val(),
                            lastname    :   $('#lastname').val(),
                            suffix      :   $('#suffix').val(),
                            division    :   $('#division').val(),
                            _token      :   '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            Swal.fire(
                                'User added successfully',
                                '',
                                'success'
                            ).then((result) => {
                                $('input').val('');
                                $('select').val('');
                            });
                        },
                        error: function(error) {
                            Swal.close();
                            if (error.status == 422) {
                                var errors = error.responseJSON.errors;

                                // Clear previous error messages
                                $('.error-message').text('');

                                // Display error messages in corresponding input fields
                                $.each(errors, function(field, messages) {
                                    $('#' +  field + '-error').text(messages[0]);
                                });
                            } else {
                                console.log(error);
                            }
                        }
                    });
                    // End of AJAX Call
                }
            })
        })
        // End of save button

        // Remove error message on change
        $('form input').on('change', function() {
            // Clear error messages
            $(this).parent().children(':last-child').text('');
        })
    });
</script>
@endsection