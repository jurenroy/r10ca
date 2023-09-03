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
            <div class="w-full grid grid-rows-4 gap-4">
                <div class="">
                    <label for="firstname" class="block text-sm font-medium text-gray-500">Firstname</label>
                    <input type="text" name="firstname" id="firstname" class="w-full rounded-lg border-gray-300 shadow-lg" />
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('custom_script')

@endsection