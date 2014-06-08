@if (Session::has('flash_notification.message'))

    @if (Session::has('flash_notification.overlay'))
        @include('partials/_modal', ['modalClass' => 'flash-modal', 'title' => 'Notice', 'body' => Session::get('flash_notification.message')])
    @else
        <div class="alert alert-{{ Session::get('flash_notification.level') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('flash_notification.message') }}
        </div>
    @endif

@endif