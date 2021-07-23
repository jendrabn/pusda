 @php
   $fullcolspan = 3 + count($years);
 @endphp

 <table>
   <thead>
     <tr>
       <th>No</th>
       <th>Uraian</th>
       <th>Satuan</th>
       @foreach ($years as $y)
         <th>{{ $y }}</th>
       @endforeach
     </tr>
   </thead>
   <tbody>
     @foreach ($uraianBps as $index => $uraian)
       <tr>
         <th>{{ ++$index }}</th>
         <th colspan="{{ count($years) + 1 }}">{{ $uraian->uraian }}</th>
       </tr>
       @foreach ($uraian->childs as $uraian)
         <tr>
           <th></th>
           <th>{{ $uraian->uraian }}</th>
           <th>{{ $uraian->satuan }}</th>
           @foreach ($years as $y)
             <th>
               {{ $uraian->isiBps()->where('tahun', $y)->first()->isi ?? 0 }}
             </th>
           @endforeach
         </tr>
       @endforeach
     @endforeach

     {{-- Border --}}
     <tr>
       <td colspan="{{ $fullcolspan }}"></td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">Deskripsi:</td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}"> {{ $fiturBps->deskripsi ?? '-' }}</td>
     </tr>
     {{-- Border --}}

     {{-- Border --}}
     <tr>
       <td colspan="{{ $fullcolspan }}"></td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">Analisis:</td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">{{ $fiturBps->analisis ?? '-' }}</td>
     </tr>
     {{-- Border --}}

     {{-- Border --}}
     <tr>
       <td colspan="{{ $fullcolspan }}"></td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">Permasalahan:</td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">{{ $fiturBps->permasalahan ?? '-' }}</td>
     </tr>
     {{-- Border --}}

     {{-- Border --}}
     <tr>
       <td colspan="{{ $fullcolspan }}"></td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">Solusi atau Langkah-langkah Tindak Lanjut:</td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">{{ $fiturBps->solusi ?? '-' }}</td>
     </tr>
     {{-- Border --}}

     {{-- Border --}}
     <tr>
       <td colspan="{{ $fullcolspan }}"></td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">Saran / Rekomendasi ke Gubernur atau Pusat:</td>
     </tr>
     <tr>
       <td colspan="{{ $fullcolspan }}">{{ $fiturBps->saran ?? '-' }}</td>
     </tr>
     {{-- Border --}}
   </tbody>
 </table>
