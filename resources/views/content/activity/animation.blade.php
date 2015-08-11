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
        <audio controls>
          <source
            src="{{ asset('/sounds/FFXIV_Victory_Fanfare.ogg') }}"
            type="audio/ogg">
            Your browser does not support the audio element.
        </audio>
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
        <audio controls>
      	  <source
            src="{{ asset('/sounds/d2ef5d_Angry_Birds_Level_Complete_Sound_Effect.mp3') }}"
        		type="audio/mpeg">
      	  Your browser does not support the audio element.
      	</audio>
      </div>
      <div class="radio radio-primary">
        <label>
          <input
          type="radio"
          name="caOptions"
          id="caOptions3"
          value="3"
          {{ $activity->correct_animation === '3' ? 'checked' : '' }}>
          Set 3
        </label>
        <audio controls>
      	  <source
            src="{{ asset('/sounds/mario-state-clear.mp3') }}"
        		type="audio/mpeg">
      	  Your browser does not support the audio element.
      	</audio>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-xs-2 control-label">Incorrect animation</label>
    <div class="col-xs-10">
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
        <audio controls>
      	  <source
            src="{{ asset('/sounds/Sad_Trombone-Joe_Lamb-665429450.mp3') }}"
        		type="audio/mpeg">
      	  Your browser does not support the audio element.
      	</audio>
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
        <audio controls>
      	  <source
            src="{{ asset('/sounds/e264ad_Angry_Birds_Level_Failed_Piglets_Sound_Effect.mp3') }}"
        		type="audio/mpeg">
      	  Your browser does not support the audio element.
      	</audio>
      </div>
      <div class="radio radio-primary">
        <label>
          <input
          type="radio"
          name="iaOptions"
          id="iaOptions3"
          value="3"
          {{ $activity->correct_animation === '3' ? 'checked' : '' }}>
          Set 3
        </label>
        <audio controls>
      	  <source
            src="{{ asset('/sounds/mario-die.mp3') }}"
        		type="audio/mpeg">
      	  Your browser does not support the audio element.
      	</audio>
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
