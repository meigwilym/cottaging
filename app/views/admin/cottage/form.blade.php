<div class="form-group<?php if($errors->has('name')) echo ' has-error'; ?>">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group<?php if($errors->has('summary')) echo ' has-error'; ?>">
            {{ Form::label('summary', 'Summary') }}
            {{ Form::text('summary', null, array('class' => 'form-control input-lg', 'placeholder' => 'A short summary of the accommodation and it\'s features')) }}
            <p class="help-block">A short summary of the accommodation and it's features. This field is also the page description meta tag, so no more than 155 characters. </p>
        </div>

        <fieldset class="row">

          <div class="col-md-6 form-group<?php if($errors->has('description')) echo ' has-error'; ?>">
              {{ Form::label('description', 'Description') }}
              {{ Form::textarea('description', null, array('class' => 'form-control')) }}
          </div>

          <div class="col-md-6 form-group<?php if($errors->has('accommodation')) echo ' has-error'; ?>">
              {{ Form::label('accommodation', 'The Accommodation') }}
              {{ Form::textarea('accommodation', null, array('class' => 'form-control')) }}
          </div>

        </fieldset>

        <div class="form-group<?php if($errors->has('start_days')) echo ' has-error'; ?>">
          <label>Arrival Days</label>
          <div>
            <label class="checkbox-inline">
              {{ Form::checkbox('start_days[]', '6') }} Saturday
            </label>
            <label class="checkbox-inline">
              {{ Form::checkbox('start_days[]', '0') }} Sunday
            </label>
            <label class="checkbox-inline">
              {{ Form::checkbox('start_days[]', '1') }} Monday
            </label>
            <label class="checkbox-inline">
              {{ Form::checkbox('start_days[]', '2') }} Tuesday
            </label>
            <label class="checkbox-inline">
              {{ Form::checkbox('start_days[]', '3') }} Wednesday
            </label>
            <label class="checkbox-inline">
              {{ Form::checkbox('start_days[]', '4') }} Thursday
            </label>
            <label class="checkbox-inline">
              {{ Form::checkbox('start_days[]', '5') }} Friday
            </label>
          </div>
        </div>

        <fieldset class="row">

          <div class="col-md-3 form-group<?php if($errors->has('min_duration')) echo ' has-error'; ?>">
              {{ Form::label('min_duration', 'Minimum number of nights') }}
              {{ Form::selectRange('min_duration', 1, 7, null, array('class' => 'form-control')) }}
          </div>

          <div class="col-md-3 form-group<?php if($errors->has('sleeps')) echo ' has-error'; ?>">
              {{ Form::label('sleeps', 'Sleeps') }}
              {{ Form::selectRange('sleeps', 1, 20, null, array('class' => 'form-control')) }}
          </div>

          <div class="col-md-3 form-group<?php if($errors->has('bedrooms')) echo ' has-error'; ?>">
              {{ Form::label('bedrooms', 'Bedrooms') }}
              {{ Form::selectRange('bedrooms', 1, 12, null, array('class' => 'form-control')) }}
          </div>

          <div class="col-md-3 form-group<?php if($errors->has('bathrooms')) echo ' has-error'; ?>">
              {{ Form::label('bathrooms', 'Bathrooms') }}
              {{ Form::selectRange('bathrooms', 1, 8, null, array('class' => 'form-control')) }}
          </div>

        </fieldset>

        <fieldset class="row">
          <div class="col-md-6 form-group<?php if($errors->has('lat')) echo ' has-error'; ?>">
              {{ Form::label('lat', 'Latitude') }}
              {{ Form::text('lat', null, array('class' => 'form-control')) }}
          </div>

          <div class="col-md-6 form-group<?php if($errors->has('lon')) echo ' has-error'; ?>">
              {{ Form::label('lon', 'Longitude') }}
              {{ Form::text('lon', null, array('class' => 'form-control')) }}
          </div>
          <div class="col-md-12">
            <p>Latitude and Longitude coordinates can be <a href="http://dbsgeo.com/latlon/" target="_blank" title="Get Lat & Lon - opens in new window">obtained here</a>.</p>
          </div>
        </fieldset>

        <fieldset>

          <legend>SEO</legend>

          <div class="form-group<?php if($errors->has('page_title')) echo ' has-error'; ?>">
            {{ Form::label('page_title', 'Page Title &lt;title&gt;') }}
              {{ Form::text('page_title', null, array('class' => 'form-control')) }}
              <p class="help-block">This should contain the cottage name, area and any other keywords. No more than 70 characters.</p>
          </div>

          <div class="form-group<?php if($errors->has('keywords')) echo ' has-error'; ?>">
              {{ Form::label('keywords', 'The Keywords meta tag') }}
              {{ Form::text('keywords', null, array('class' => 'form-control')) }}
              <p class="help-block">A comma separated list of keywords. Not used by Google since 2009, but here for completeness.</p>
          </div>
        </fieldset>

        <fieldset>
          <legend>Features</legend>
            <div class="form-group cottage-features">
                @foreach($features as $f)
                <label class="checkbox">
                  <?php
                  $checked = (isset($cottage) && $cottage->features->contains($f->id)) ? true: false;
                  ?>
                  {{ Form::checkbox('feature[]', $f->id, $checked) }} {{ $f->name }}
                </label>
                @endforeach
            </div>
        </fieldset>

        <!--
        <?php // after the sorting function is done ?>
        <fieldset class="row">
          <legend>Areas</legend>
          <?php // $parent_id = 0; ?>
          @foreach($areas as $a)
          <label class="checkbox">
            {{ Form::checkbox('area[]', $a->id) }} {{ $a->area }}
          </label>
          @endforeach
        </fieldset>
        -->