   <ul>
     <li> RPJMD {{ $skpd->singkatan }}
       @foreach ($categories as $category)
         @if ($category->childs->count())
           <ul>
             @foreach ($category->childs as $child)
               <li>
                 {{ $child->menu_name }}
                 <ul>
                   @foreach ($child->childs as $child)
                     <li>
                       {{ $child->menu_name }}
                       @if ($child->childs->count())
                         <ul>
                           @foreach ($child->childs as $child)
                             @foreach ($tabelRpjmdIds as $table)
                               @if ($table->id == $child->id)
                                 <li @if (isset($tabelRpjmd) && $tabelRpjmd->id == $table->id) data-jstree='{ "selected" : true }' @endif>
                                   <a href="{{ route('skpd.rpjmd.index', $child->id) }}">{{ $child->menu_name }}</a>
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
