@props(['type' => 'info', 'text'])

@php
  $classes = [
    'info' => 'background-color: lightblue; border: 1px solid blue;',
    'danger' => 'background-color: lightcoral; border: 1px solid red;',
    'success' => 'background-color: lightgreen; border: 1px solid green;',
  ];
@endphp

<div style="{{ $classes[$type]}} padding: 8px 12px; text-align: center; width: 300px; border-radius: 8px; margin: 20px;">
  <p>{{$text}}</p>
</div>