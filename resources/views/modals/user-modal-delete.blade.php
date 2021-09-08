<div class="modal-info-delete modal fade show" id="confirmDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-info" role="document">
      <div class="modal-content">
          <div class="modal-body">
              <div class="modal-info-body d-flex">
                  <div class="modal-info-icon warning">
                      <span data-feather="info"></span>
                  </div>
                  <div class="modal-info-text">
                      <h6>Do you want to delete this user?</h6>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            {!! Form::button('Cancel', array('class' => 'btn btn-sucess btn-outlined btn-sm', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
            {!! Form::button('Confirm Delete', array('class' => 'btn btn-danger btn-outlined btn-sm', 'type' => 'button', 'id' => 'confirm' )) !!}
          </div>
      </div>
  </div>


</div>
