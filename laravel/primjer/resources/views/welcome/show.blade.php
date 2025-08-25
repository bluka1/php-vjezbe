<div>
  Moj omiljeni hobby je <?= $hob ?>
</div>

<div>
  Moje najdraże voće je {{ $fr }}
</div>

@include('error')

<ul>
  @foreach ($niz as $prijatelj)
      <li>{{ $prijatelj }}

        @if ($loop->last)
          (posljednji u nizu)
        @endif
        @if ($loop->first)
          (prvi u nizu)
        @endif
      </li>
  @endforeach
</ul>