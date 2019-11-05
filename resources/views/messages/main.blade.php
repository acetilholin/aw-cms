@if ($message = Session::get('info'))
    <div class="alert alert-info text-center" role="alert" id="message">
        {{ $message }}
    </div>
@endif

<style>
    .alert-info {
        background-color: #e9ecef !important;
        border-color: #e9ecef !important;
    }
</style>
