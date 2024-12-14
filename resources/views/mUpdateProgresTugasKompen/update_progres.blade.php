<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Progress</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <input type="hidden" id="task-id" value="{{ $task->id_tugas_kompen }}">
                <div class="form-group">
                    <label for="progress-input">Progress</label>
                    <input type="text" class="form-control" id="progress-input" value="{{ $task->progress }}">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" id="save-progress-btn" class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
