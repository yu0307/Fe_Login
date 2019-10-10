<div class="modal fade" tabindex="-1" role="dialog" id="usrManagementCtr">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create a user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('fe_login::outletViews.userManagementCRUD')
            <div id="usrManageWinMsg" class="hidden">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="usrSave">Save changes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>