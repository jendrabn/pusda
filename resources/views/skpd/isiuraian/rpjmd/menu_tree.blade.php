   <ul>
     <li> RPJMD {{ $skpd->singkatan }}
       @foreach ($categories as $category)
         @if ($category->childs->count())
           <ul>
             @foreach ($category->childs as $child)
               <li>
                 {{ $child->nama_menu }}
                 <ul>
                   @foreach ($child->childs as $child)
                     <li>
                       {{ $child->nama_menu }}
                       @if ($child->childs->count())
                         <ul>
                           @foreach ($child->childs as $child)
                             @foreach ($tabelRpjmdIds as $table)
                               @if ($table->id == $child->id)
                                 <li @if (isset($tabelRpjmd) && $tabelRpjmd->id == $table->id) data-jstree='{ "selected" : true }' @endif>
                                   <a href="{{ route('skpd.rpjmd.input', $child->id) }}">{{ $child->nama_menu }}</a>
                                 </li>
                               @endif
                             @endforeach
                           @endforeach
                         </ul>
                       @endif
                     </li>
                   @endforeach
                 </ul>
               </li>
             @endforeach
           </ul>
         @endif
     </li>
     @endforeach
   </ul>
