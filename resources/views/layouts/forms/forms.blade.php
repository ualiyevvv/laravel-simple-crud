<div class="form-group">
    <input type="text" class="form-control" name="title" value="{{old('title') ?? $post->title ?? ''}}" required>
</div>
<div class="form-group">
    <textarea name="descr" class="form-control" id="" rows="10" required>{{old('descr') ?? $post->descr ?? ''}}</textarea>
</div>
<div class="form-group">
    <input type="file" name="img" >
</div>
