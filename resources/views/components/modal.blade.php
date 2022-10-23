<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{$title}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{$slot}}
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
        @if ($onlyClose)
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
        @endif
      </div>
    </div>
</div>