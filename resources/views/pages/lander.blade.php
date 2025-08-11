@auth
<x-app-layout>
    @include('pages.lander._hero')
    @include('pages.lander._stats')
    @include('pages.lander._features-cta')
    @include('pages.lander._testimonials')
</x-app-layout>
@endauth
@guest
<x-guest-layout>
<a href="{{ route('register') }}">Register</a>
<a href="{{ route('login') }}">Login</a>
</x-guest-layout>
@endguest
