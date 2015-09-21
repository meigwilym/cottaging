
{{ Form::open(array('uses' => 'SearchController@doSearch', 'role'=>'form')) }}

<div class="row">
  <div class="col-sm-12">
    
    <div class="form-group">
      <label class="form-label">Arrive</label>
      <input type="text" class="form-control" name="arrive" value="">
    </div>
    
    <div class="form-group">
      <label class="form-label">Depart</label>
      <input type="text" class="form-control" name="depart" value="">
    </div>
    
    <div class="form-group">
      <label class="form-label">Number in Party</label>
      <select name="number">
        <?php for($i=1;$i<13;$i++): ?>
          <option value="{{ $i }}">{{ $i }}</option>
        <?php endfor; ?>
      </select>
    </div>
    
  </div>
</div>


{{ Form::close() }}