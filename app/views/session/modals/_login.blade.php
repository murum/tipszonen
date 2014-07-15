<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="loginModalLabel">Logga in på Lajvrättning</h3>
            </div>
            <div class="modal-body">
                @include('session/partials/_form')
            </div>
        </div>
    </div>
</div>
