<!-- 所有的错误提示 -->
{{--count()返回 var 中的单元数目，通常是一个 array（任何其它类型都只有一个单元）。--}}
{{--如果 var 不是数组类型，将返回 1--}}
@if(count($errors))
<div class="alert alert-danger form-top-left" style="margin-top: 10px">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
