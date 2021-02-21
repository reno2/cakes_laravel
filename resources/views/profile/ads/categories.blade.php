@foreach($categories as $category)

<option value="{{$category->id ?? ''}}"
	@isset($ads->id)
		@foreach($ads->categories as $category_article)
			@if($category->id == $category_article->id)
				selected="selected"
			@endif
		@endforeach
	@endisset
>
	{!! $delimiter ?? '' !!}{{$category->title ?? ''}}
</option>
	@if(count($category->children) > 0)
		@include('profile.ads.categories', [
			'categories'=> $category->children,
			'delimiter' => ' - ' . $delimiter
		])
	@endif
@endforeach
