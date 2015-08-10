<form class="form-horizontal" id="animationForm">
  <div class="form-group">
    <label class="col-xs-2 control-label">Correct animation</label>
    <div class="col-xs-10">
      <div class="radio radio-primary">
        <label>
          <input
          type="radio"
          name="caOptions"
          id="caOptions1"
          value="1"
          {{ $activity->correct_animation === '1' ? 'checked' : '' }}>
          Set 1
        </label>
      </div>
      <div class="radio radio-primary">
        <label>
          <input
          type="radio"
          name="caOptions"
          id="caOptions1"
          value="2"
          {{ $activity->correct_animation === '2' ? 'checked' : '' }}>
          Set 2
        </label>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-xs-2 control-label">Incorrect animation</label>
    <div class="col-xs-3">
      <div class="radio radio-primary">
        <label>
          <input
          type="radio"
          name="iaOptions"
          id="iaOptions1"
          value="1"
          {{ $activity->correct_animation === '1' ? 'checked' : '' }}>
          Set 1
        </label>
      </div>
      <div class="radio radio-primary">
        <label>
          <input
          type="radio"
          name="iaOptions"
          id="iaOptions2"
          value="2"
          {{ $activity->correct_animation === '2' ? 'checked' : '' }}>
          Set 2
        </label>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-xs-10 col-xs-offset-2">
      <button type="button" class="btn btn-primary" onclick="saveAnimation({{$activity->id}})">
        Use new animation
      </button>
    </div>
  </div>

</form>
