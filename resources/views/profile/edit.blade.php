<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Profile Information') }}
                        </h2>

                        <a href="{{ route('profile.edit') }}">Edit Profile</a> 

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <h2 class="text-lg font-medium text-gray-900 mt-6">
                            {{ __('Profile Media') }}
                        </h2>

                        <div>
                            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" accept="image/*" />
                            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
                        </div>

                        <div>
                            <x-input-label for="background_picture" :value="__('Background Picture')" />
                            <input id="background_picture" name="background_picture" type="file" class="mt-1 block w-full" accept="image/*" />
                            <x-input-error class="mt-2" :messages="$errors->get('background_picture')" />
                        </div>

                        @if($user->profile_picture)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">Current Profile Picture:</p>
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Current Profile Picture" class="mt-2 w-32 h-32 object-cover rounded-full">
                            </div>
                        @endif

                        @if($user->background_picture)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">Current Background Picture:</p>
                                <img src="{{ Storage::url($user->background_picture) }}" alt="Current Background Picture" class="mt-2 w-full h-32 object-cover rounded">
                            </div>
                        @endif

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
