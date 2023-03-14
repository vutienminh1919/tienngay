@extends('viewcpanel::layouts.master')

@section('title', 'Open app')

@section('css')
@endsection

@section('content')

@endsection

@section('script')
<script type="text/javascript">
  var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
  if (isIOS) {
    window.location.replace("https://apps.apple.com/vn/app/tienngay-vn-%C4%91%E1%BA%A7u-t%C6%B0-t%C3%ADch-lu%E1%BB%B9/id1563318851?l=vi");
  } else {
    window.location.replace("https://play.google.com/store/apps/details?id=vn.tienngay.investor");
  }
</script>
@endsection
