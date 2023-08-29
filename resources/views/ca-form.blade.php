@extends('base')

@section('title', 'Certificate of Appreciation Form')

@section('content')
<div class="container mx-auto mt-20 border-2 rounded-lg min-h-fit py-2">
    <h1 class="text-3xl text-center font-bold">Certificate of Appearance</h1>

    <hr class="border border-[2px] border-red-500 m-5">

    <form action="#" method="post" class="px-5">
        <!-- Fullname -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" name="fullname" id="fullname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
            
            <label for="fullname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fullname (Firstname M.I Lastname, Suffix)</label>
            <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="fullname-error"></span>
        </div>
        

        <!-- Company/Organization -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" name="company" id="company" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
            
            <label for="company" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Company/Organization(Write N/A if not applicable)</label>
            <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="company-error"></span>
        </div>

        <div class="grid md:grid-cols-2 md:gap-6">
            <!-- Date From -->
            <div class="relative z-0 w-full mb-6 group">
                <input type="date" name="date_from" id="date_from" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
                
                <label for="date_from" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date From</label>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="date_from-error"></span>
            </div>

            
            <!-- Date To -->
            <div class="relative z-0 w-full mb-6 group">
                <input type="date" name="date_to" id="date_to" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
                
                <label for="date_to" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date To</label>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="date_to-error"></span>
            </div>
        </div>

        <!-- Purpose -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" name="purpose" id="purpose" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
            
            <label for="purpose" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Purpose</label>
            <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="purpose-error"></span>
        </div>

        <button type="button" class="bg-green-500 hover:bg-red-500 transition-colors duration-300 linear text-white px-4 py-2 rounded-full font-bold" id="submit">Submit Form</button>


    </form>
</div>
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        
        // Perform when form is submitted
        $('#submit').on('click', function() {

            // Open Modal
            Swal.fire({
                title: 'Please wait while saving.....',
                didOpen: () => {
                    // Display Loading while saving sequence in progress
                    Swal.showLoading();
                    // AJAX Call for saving and sending the CA
                    $.ajax({
                        url: '{{ route('save.log') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            fullname    :   $('#fullname').val(),
                            company     :   $('#company').val(),
                            date_from   :   $('#date_from').val(),
                            date_to     :   $('#date_to').val(),
                            purpose     :   $('#purpose').val(),
                            _token      :   '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            Swal.fire(
                                'Save successfully',
                                'Please get your Certificate of Appearance at the FRONTDESK. Thank you.',
                                'success'
                            ).then((result) => {
                                $('input').val('');
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
                },
            });
            // End of Modal
        });
        // End of button click - Submit

        // Remove error message on change
        $('form input').on('change', function() {
            // Clear error messages
            $(this).parent().children(':last-child').text('');
        })
    });
</script>
@endsection