<!-- 20251128 -->
{{-- 部分テンプレートとは？
再利用可能なHTMLの部品
同じテーブル構造を複数の場所で使える
メンテナンスが簡単（1箇所修正すれば全体に反映） --}}
{{-- 学生一覧テーブル部分テンプレート --}}
@if($students->count() > 0)
    <table>
        <thead>
            <tr>
                <th>学年</th>
                <th>名前</th>
                <th>住所</th>
                <th class="actions-cell">詳細表示</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>
                    <span class="student-year">{{ $student->grade }}年生</span>
                </td>
                <td class="student-name">{{ $student->name }}</td>
                <td>{{ $student->address }}</td>
                <td class="actions-cell">
                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-primary btn-sm">
                        詳細表示
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ページネーション --}}
    @if($students->hasPages())
    <div style="padding: 20px 24px; border-top: 1px solid #e2e8f0;">
        {{ $students->appends(request()->query())->links() }}
    </div>
    @endif
@else
    {{-- 検索結果が0件の場合 --}}
    <div class="empty-state">
        <div class="empty-state-icon">📭</div>
        <h3>学生が見つかりませんでした</h3>
        <p>検索条件を変更してください。</p>
    </div>
@endif