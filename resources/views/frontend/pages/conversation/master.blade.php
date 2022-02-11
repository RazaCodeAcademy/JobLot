<!DOCTYPE html>
<html lang="en">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('frontend.pages.conversation.head')
<body onload="getConversationList()">
    @yield('content')
    @include('frontend.pages.conversation.scripts')
</body>
</html>