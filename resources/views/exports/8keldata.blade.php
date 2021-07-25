 @php
   $fullcolspan = 3 + count($years);
 @endphp

 <table>
   <thead>
     <tr>
       <th>No</th>
       <th>Uraian</th>
       <th>Satuan</th>
       <th>Ketersedian Data</th>
       @foreach ($years as $y)
         <th>{{ $y }}</th>
       @endforeach
       <th>Sumber Data</th>
     </tr>
   </thead>
   <tbody>
     @foreach ($uraian8KelData as $index => $uraian)
       <tr>
         <th>{{ ++$index }}</th>
         <th colspan="{{ count($years) + 1 }}">{{ $uraian->uraian }}</th>
       </tr>
       @foreach ($uraian->childs as $uraian)
         <tr>
           <th></th>
           <th>{{ $uraian->uraian }}</th>
           <th>{{ $uraian->satuan }}</th>
           <th>{{ $uraian->ketersediaan_data_text }}</th>
           @foreach ($years as $y)
             <th>
               {{ $uraian->isi8KelData()->where('tahun', $y)->first()->isi ?? 0 }}
             </th>
           @endforeach
           <th>{{ $uraian->skpd->nama ?? '' }}</th>
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
       <td colspan="{{ $fullcolspan }}"> {{ $fitur8Keldata->deskripsi ?? '-' }}</td>
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
       <td colspan="{{ $fullcolspan }}">{{ $fitur8Keldata->analisis ?? '-' }}</td>
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
       <td colspan="{{ $fullcolspan }}">{{ $fitur8Keldata->permasalahan ?? '-' }}</td>
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
       <td colspan="{{ $fullcolspan }}">{{ $fitur8Keldata->solusi ?? '-' }}</td>
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
       <td colspan="{{ $fullcolspan }}">{{ $fitur8Keldata->saran ?? '-' }}</td>
     </tr>
     {{-- Border --}}
   </tbody>
 </table>
