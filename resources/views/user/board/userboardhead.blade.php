<div class="container header repohead">
    <span class="username-header">
        <a href="/{{Auth::user()->username}}">{{Auth::user()->username}}</a>
        <span style="margin: 0em 0.25em 0em 0.25em; font-size: larger; font-weight: bold;">/</span>
        <a href="/{{Auth::user()->username}}/{{$board->name}}">{{$board->name}}</a>
    </span>
</div>