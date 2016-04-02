<form class="form-horizontal" id="imageForm">

  <input type="hidden" name="activity_id" value="{{$activity->id}}">

  <div class="form-group">
    <label for="inImage" class="col-xs-2 control-label">Image</label>
    <div class="col-xs-10">
      <input
      class="form-control"
      id="inImage"
      name="inImage"
      type="file"
      accept="image/*">
    </div>
  </div>

  <div class="form-group">
    <div class="col-xs-10 col-xs-offset-2">
      <button type="button" class="btn btn-primary" onclick="saveImage()">Use new image</button>
    </div>
  </div>
</form>
