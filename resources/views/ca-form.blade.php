@extends('base')

@section('title', 'Certificate of Appreciation Form')

@section('content')
<div class="container mx-auto mt-20 border-2 rounded-lg min-h-fit py-2">
    
    <!-- Title & Toggle Button -->
    <div class="text-center mb-4">
        <h1 class="text-3xl font-bold" id="formTitle">Certificate of Appearance</h1>
        <div class="mt-2">
            <button type="button" id="formToggle" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Switch to DENR Employee
            </button>
        </div>
    </div>

    <hr class="border border-[2px] border-red-500 m-5">

    <form action="#" method="post" class="px-5">
        <!-- Fullname -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" name="fullname" id="fullname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
            <label for="fullname" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">Fullname (Firstname M.I Lastname, Suffix)</label>
            <span class="error-message text-red-500 text-xs mt-1 ml-1" id="fullname-error"></span>
        </div>

        <!-- DENR Position Field: only visible when DENR Employee is selected -->
        <div id="denrPosition" class="hidden">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="position" id="position" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                <label for="position" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">Position</label>
            </div>
        </div>

        <!-- Company/Organization -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" name="company" id="company" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
            <label for="company" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">Company/Organization (Write N/A if not applicable)</label>
            <span class="error-message text-red-500 text-xs mt-1 ml-1" id="company-error"></span>
        </div>

        <div class="grid md:grid-cols-2 md:gap-6">
            <!-- Date From -->
            <div class="relative z-0 w-full mb-6 group">
                <input type="date" name="date_from" id="date_from" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="date_from" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">Date From</label>
                <span class="error-message text-red-500 text-xs mt-1 ml-1" id="date_from-error"></span>
            </div>

            <!-- Date To -->
            <div class="relative z-0 w-full mb-6 group">
                <input type="date" name="date_to" id="date_to" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="date_to" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">Date To</label>
                <span class="error-message text-red-500 text-xs mt-1 ml-1" id="date_to-error"></span>
            </div>
        </div>

        <!-- Purpose -->
        <div class="relative z-0 w-full mb-6 group">
            <input type="text" name="purpose" id="purpose" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="purpose" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]">Purpose</label>
            <span class="error-message text-red-500 text-xs mt-1 ml-1" id="purpose-error"></span>
        </div>

        <!-- DENR Employee Extra Fields -->
        <div id="denrFields" class="hidden mt-8">

            <!-- Provided / Not Provided Table -->
            <div class="w-full mb-6 overflow-x-auto">
                <table class="table-auto w-full border border-gray-300 text-sm text-left">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Item</th>
                            <th class="border px-4 py-2 text-center">Provided</th>
                            <th class="border px-4 py-2 text-center">Not Provided</th>
                            <th class="border px-4 py-2">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['Accommodation', 'Food', 'Transportation', 'Others'] as $item)
                            @php
                                $name = strtolower(str_replace([' ', '(', ')'], ['_', '', ''], $item));
                                $displayName = ($item == 'Others') ? $item . ' (Specify)' : $item;
                            @endphp
                            <tr>
                                <td class="border px-4 py-2">{{ $displayName }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <input type="radio" name="{{ $name }}_provided" value="1">
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <input type="radio" name="{{ $name }}_provided" value="0">
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="text" name="{{ $name }}_remarks" class="w-full px-2 py-1 border rounded">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="button" class="bg-green-500 hover:bg-red-500 transition-colors duration-300 linear text-white px-4 py-2 rounded-full font-bold" id="submit">Submit Form</button>
    </form>
</div>
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        let isDENR = false;
            
        $('#formToggle').on('click', function () {
            isDENR = !isDENR;
        
            if (isDENR) {
                $('#denrFields').removeClass('hidden');
                $('#denrPosition').removeClass('hidden');
                $('#formTitle').text('DENR Employee Form');
                $(this).text('Switch to Certificate of Appearance');
            } else {
                $('#denrFields').addClass('hidden');
                $('#denrPosition').addClass('hidden');
                $('#formTitle').text('Certificate of Appearance');
                $(this).text('Switch to DENR Employee');
            }
        });

        $('#submit').on('click', function() {
            Swal.fire({
                title: 'Please wait while saving.....',
                didOpen: () => {
                    Swal.showLoading();

                    $.ajax({
                        url: '{{ route('save.log') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            fullname: $('#fullname').val(),
                            company: $('#company').val(),
                            date_from: $('#date_from').val(),
                            date_to: $('#date_to').val(),
                            purpose: $('#purpose').val(),
                            position: $('#position').val(),
                            accommodation_provided: $('input[name="accommodation_provided"]:checked').val(),
                            accommodation_remarks: $('input[name="accommodation_remarks"]').val(),
                            food_provided: $('input[name="food_provided"]:checked').val(),
                            food_remarks: $('input[name="food_remarks"]').val(),
                            transportation_provided: $('input[name="transportation_provided"]:checked').val(),
                            transportation_remarks: $('input[name="transportation_remarks"]').val(),
                            others_provided: $('input[name="others_provided"]:checked').val(),
                            others_remarks: $('input[name="others_remarks"]').val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            Swal.fire(
                                'Saved successfully',
                                'Please get your Certificate of Appearance at the FRONTDESK. Thank you.',
                                'success'
                            ).then(() => {
                                $('form')[0].reset();
                                $('#denrFields').addClass('hidden');
                                $('#denrPosition').addClass('hidden');
                                $('#formTitle').text('Certificate of Appearance');
                                $('#formToggle').text('Switch to DENR Employee');
                                isDENR = false;
                            });
                        },
                        error: function(error) {
                            Swal.close();
                            if (error.status == 422) {
                                let errors = error.responseJSON.errors;
                                $('.error-message').text('');
                                $.each(errors, function(field, messages) {
                                    $('#' + field + '-error').text(messages[0]);
                                });
                            } else {
                                console.log(error);
                            }
                        }
                    });
                },
            });
        });

        $('form input').on('change', function() {
            $(this).parent().children(':last-child').text('');
        });
    });
</script>
@endsection
