@extends('beautymail::templates.minty')

@section('content')

	@include('beautymail::templates.minty.contentStart')
		<tr>
			<td class="title text-center">
				Terima Kasih Telah Mendaftar Workshop {{ $name }}
			</td>
		</tr>
		<tr>
			<td width="100%" height="10"></td>
		</tr>
		<tr>
			<td class="paragraph text-center">
				<img src="data:image/png;base64, {!! base64_encode($qr) !!} ">
			</td>
		</tr>
		<tr>
			<td class="text-center" width="100%">
				{!! $qr !!}
			</td>
		</tr>
		{{-- <tr>
			<td class="title">
				This is a heading
			</td>
		</tr> --}}
		<tr>
			<td width="100%" height="10"></td>
		</tr>
		{{-- <tr>
			<td class="paragraph">
				
			</td>
		</tr>
		<tr>
			<td width="100%" height="25"></td>
		</tr>
		<tr>
			<td>
				@include('beautymail::templates.minty.button', ['text' => 'Sign in', 'link' => '#'])
			</td>
		</tr>
		<tr>
			<td width="100%" height="25"></td>
		</tr> --}}
	@include('beautymail::templates.minty.contentEnd')

@stop