@extends('layouts.app')

@section('title', 'แดชบอร์ดการศึกษา')

@section('content')
    <div class="w-full p-6 shadow bg-base-200 rounded-2xl">
        <div class="flex items-center justify-end pb-4 mb-6 border-b">
            <a href="{{ route('courses.create') }}" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                <i class="fa-solid fa-plus mr-2 text-base-100"></i>สร้างคอร์ส</a>
        </div>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">คอร์สทั้งหมด</div>
                <div class="mt-1 text-2xl font-bold text-blue-600">{{ $totals['all'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">เผยแพร่</div>
                <div class="mt-1 text-2xl font-bold text-green-600">{{ $totals['open'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">ฉบับร่าง</div>
                <div class="mt-1 text-2xl font-bold text-gray-600">{{ $totals['draft'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">รออนุมัติ</div>
                <div class="mt-1 text-2xl font-bold text-yellow-600">{{ $totals['pending'] ?? 0 }}</div>
            </div>
            <div class="p-4 bg-white shadow rounded-xl">
                <div class="text-sm text-gray-500">ผู้เข้าร่วมทั้งหมด</div>
                <div class="mt-1 text-2xl font-bold text-violet-600">{{ $participants ?? 0 }}</div>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="mb-3 text-xl font-semibold">คอร์สล่าสุด</h2>
            <div class="overflow-x-auto bg-white shadow rounded-xl">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ชื่อคอร์ส</th>
                            <th>สถานะ</th>
                            <th>ผู้เข้าร่วม</th>
                            <th>การทำงาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCourses as $c)
                            @php
                                $badge = [
                                    'open' => 'bg-green-300 text-green-700',
                                    'draft'=> 'bg-gray-300 text-gray-700',
                                    'closed'=> 'bg-red-300 text-red-700',
                                    'pending'=> 'bg-yellow-300 text-yellow-700',
                                ][$c->c_status] ?? 'bg-gray-200';
                            @endphp
                            <tr>
                                <td class="max-w-[300px] line-clamp-1">{{ $c->c_name }}</td>
                                <td><span class="px-3 py-1 text-sm rounded-full {{ $badge }}">{{ $c->status_text }}</span></td>
                                <td>{{ $c->participants }}</td>
                                <td>
                                    <div class="join">
                                        <a href="{{ route('courses.show', $c->c_id) }}" class="join-item btn btn-sm">ดู</a>
                                        <a href="{{ route('courses.edit', $c->c_id) }}" class="join-item btn btn-sm">แก้ไข</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">ยังไม่มีคอร์ส</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-6 p-4 bg-base-100 rounded-2xl shadow">
        <h3 class="text-lg font-semibold mb-3">Top 5 Skills (คอร์สของฉัน)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative h-[300px]"><canvas id="edu-skill-pie"></canvas></div>
            <div id="edu-skill-legend" class="flex flex-col gap-2"></div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (async function(){
                try{
                    const res = await fetch("{{ route('education.skills.data') }}");
                    const j = await res.json();
                    const el = document.getElementById('edu-skill-pie');
                    const colors = ['#60a5fa','#34d399','#f472b6','#f59e0b','#a78bfa'];
                    new Chart(el.getContext('2d'), {
                        type: 'doughnut',
                        data: { labels: j.labels, datasets: [{ data: j.data, backgroundColor: colors, borderWidth: 0 }] },
                        options: { responsive: true, maintainAspectRatio: false, plugins:{ legend:{ display:false } } }
                    });
                    const legend = document.getElementById('edu-skill-legend');
                    legend.innerHTML = j.labels.map((lb,i)=>`
                        <div class=\"flex items-center gap-3 p-2 rounded bg-base-200\">
                            <span class=\"inline-block w-3 h-3 rounded\" style=\"background:${colors[i%colors.length]}\"></span>
                            <span class=\"flex-1\">${lb}</span>
                            <span class=\"text-sm text-gray-600\">attempts: <b>${j.data[i]||0}</b></span>
                            <span class=\"text-sm text-gray-600\">avg: <b>${(j.avg[i]||0)}%</b></span>
                        </div>
                    `).join('');
                }catch(e){ console.error(e); }
            })();
        </script>
    </div>
@endsection
