@extends('base')

@section('title', 'New user')

@section('content')
<section class="h-full m-2 rounded-lg bg-slate-200 dark:bg-neutral-700">
    <form action="#" method="post">
        <div class="md:mx-3 md:p-6">
            <h1 class="text-2xl font-bold">Add new account</p>

            <!-- Fullname -->
            <div class="relative z-0 w-full my-6 group">
                <input type="text" name="fullname" id="fullname" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " autocomplete="off" required />
                
                <label for="fullname" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fullname (Firstname M.I Lastname, Suffix)</label>
                <span class="error-message flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1" id="fullname-error"></span>
            </div>

        </div>
    </form>
</section>
@endsection

@section('custom_script')

@endsection