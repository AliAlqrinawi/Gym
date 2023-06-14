<label for="exampleInputEmail1">{{ __('Videos') }} :</label>
<select name="id_videos[]" multiple="multiple" data-name="id_videos" class="testselect2 form-group">
    @foreach ($videos as $value)
        <option value="{{ $value->id }}">
            {{ app()->getLocale() == 'en' ? $value->title_en : $value->title_ar }}</option>
    @endforeach
</select>
