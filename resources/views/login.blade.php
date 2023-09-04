<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CA | Login</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
        @vite('resources/css/app.css')
    </head>

    <body class="bg-slate-300 dark:bg-neutral-700">
        <section class="h-screen flex justify-center">
            <div class="h-full p-10">
                <div class="flex h-full flex-wrap items-center text-neutral-800 dark:text-neutral-200">
                    <div class="w-[30rem]">
                        
                        <div class="flex justify-center">
                            <img src="{{ asset('images/ca-logo.png') }}" alt="Certificate of Appearance Logo" class="w-full md:w-1/2 lg:w-1/3 xl:w-3/5">
                        </div>

                        <div class="block rounded-lg bg-white shadow-lg dark:bg-neutral-800">
                            <div class="lg:flex lg:flex-wrap">
                                <!-- Left column container-->
                                <div class="px-4 md:px-0 lg:w-full">
                                    <div class="md:mx-3 md:p-6">
                                        <form>
                                            <p class="mb-4 font-bold">Please login to your account</p>
                                            <!-- Username -->
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="text" name="username" id="username" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
                                                
                                                <label for="username" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
                                                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="username-error"></span>
                                            </div>

                                            <!-- Password -->
                                            <div class="relative z-0 w-full mb-6 group">
                                                <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
                                                
                                                <label for="password" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                                                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="password-error"></span>
                                            </div>

                                            <!--Submit button-->
                                            <div class="mb-12 pb-1 pt-1 text-center">
                                                <button class="mb-3 inline-block w-full rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_rgba(0,0,0,0.2)] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)] focus:outline-none focus:ring-0 active:shadow-[0_8px_9px_-4px_rgba(0,0,0,0.1),0_4px_18px_0_rgba(0,0,0,0.2)]" type="button" data-te-ripple-init data-te-ripple-color="light" style="background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);" id="loginBtn" disabled>Log in</button>

                                                <!--Forgot password link-->
                                                <a href="#!">Forgot password?</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Check if input is empty
                $('input').on('keyup', function() {
                    if($('#username').val() !== '' && $('#password').val() !== '') {
                        $('#loginBtn').prop("disabled", false);
                    } else {
                        $('#loginBtn').prop("disabled", true);
                    }
                });

                // When login is click
                $('#loginBtn').click(function() {
                    // Make AJAX call for login sequence
                    $.ajax({
                        url: '{{ route('login.post') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            username    :   $('#username').val(),
                            password    :   $('#password').val(),
                            _token      :   '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if(response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                console.log(response);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                    // End of AJAX call
                });
                // End of Login button
            });
        </script>
    </body>
</html>