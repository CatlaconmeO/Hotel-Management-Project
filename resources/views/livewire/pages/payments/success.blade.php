@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="text-center">
                    <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ $title }}
                    </h2>
                    <p class="text-gray-600">
                        {{ $message }}
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}"
                           class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Trở về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
