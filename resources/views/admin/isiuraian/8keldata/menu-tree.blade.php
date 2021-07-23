   <ul>
     <li data-jstree='{"opened":true}'>8 Kelompok Data
       @foreach ($categories as $category)
         @if ($category->childs->count())
           <ul>
             @foreach ($category->childs as $child)
               <li>
                 {{ $child->menu_name }}
                 @if ($child->childs->count())
                   <ul>
                     @foreach ($child->childs as $child)
                       <li> {{ $child->menu_name }}
                         <ul>
                           @if ($child->childs->count())
                             @foreach ($child->childs as $child)
                               @if ($skpdIds)
                                 @foreach ($skpdIds as $item)
                                   @if ($child->skpd_id === $item->id)
                                     <li @if (isset($tabel8KelData) && $tabel8KelData->id == $child->id) data-jstree='{ "selected" : true }' @endif>
                                       <a
                                         href="{{ route('admin.delapankeldata.index', $child->id) }}">{{ $child->menu_name }}</a>
                                     </li>
                                   @endif
                                 @endforeach
                               @else
                                 <li @if (isset($tabel8KelData) && $tabel8KelData->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                                   <a
                                     href="{{ route('admin.delapankeldata.index', $child->id) }}">{{ $child->menu_name }}</a>
                                 </li>
                               @endif
                             @endforeach
                           @endif
                         </ul>
                       </li>
                     @endforeach
                   </ul>
                 @endif
               </li>
             @endforeach
           </ul>
         @endif
     </li>
     @endforeach
   </ul>
