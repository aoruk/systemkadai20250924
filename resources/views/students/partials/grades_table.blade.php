<!-- 20251129 -->
{{-- 成績一覧テーブル部分テンプレート --}}
@if($grades->count() > 0)
    <div class="grades-table-wrapper">
        <table class="grades-table">
            <thead>
                <tr>
                    <th>学年</th>
                    <th>学期</th>
                    <th>国語</th>
                    <th>数学</th>
                    <th>理科</th>
                    <th>社会</th>
                    <th>音楽</th>
                    <th>家庭科</th>
                    <th>英語</th>
                    <th>美術</th>
                    <th>保健体育</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->grade }}年</td>
                    <td>{{ $grade->semester }}学期</td>
                    <td>{{ $grade->japanese ?? '-' }}</td>
                    <td>{{ $grade->math ?? '-' }}</td>
                    <td>{{ $grade->science ?? '-' }}</td>
                    <td>{{ $grade->social ?? '-' }}</td>
                    <td>{{ $grade->music ?? '-' }}</td>
                    <td>{{ $grade->home_economics ?? '-' }}</td>
                    <td>{{ $grade->english ?? '-' }}</td>
                    <td>{{ $grade->art ?? '-' }}</td>
                    <td>{{ $grade->health ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="no-grades">
        <div class="no-grades-icon">📝</div>
        <p>該当する成績が見つかりませんでした</p>
    </div>
@endif