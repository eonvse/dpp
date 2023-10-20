<table>
    <thead>
        <tr>
            <th colspan="14">АИС "Мониторинг ДПП". Отчет по курсам ДПП.</th>
        </tr>
        @if (!empty($filter))        
        <tr>
            <th colspan="14">{{ implode('.',$filter) }}</th>
        </tr>
        @endif
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Учреждение</th>
            <th>Должность</th>
            <th>Тип ДПП</th>
            <th>Часов ДПП</th>
            <th>Наименование ОУ,<br />выдавшего документ</th>
            <th>Входит<br /> в Федеральный реестр</th>
            <th>Наименование ДПП</th>
            <th>Направление ДПП</th>
            <th>Тип документа</th>
            <th>Дата документа</th>
            <th>Дата заполнения</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>
                {{ $item->Teacher->surname }} 
            </td>
            <td>
                {{ !empty($item->Teacher->name) ? $item->Teacher->name : '' }}
            </td>
            <td>
                {{ !empty($item->Teacher->patronymic) ? $item->Teacher->patronymic : '' }}
            </td>
            <td>
                {{ !empty($item->Teacher->institution->name) ? $item->Teacher->institution->name : '' }} 
            </td>
            <td>
                {{ !empty($item->Teacher->position->name) ? $item->Teacher->position->name : '' }} 
            </td>
            <td>
                @if (!empty($item->idType))
                {{ $item->courseType->name }}
                @endif
            </td>
            <td>{{ $item->hours }}</td>
            <td>{{ $item->fullName }}</td>
            <td>{{ !empty($item->isFederal) ? 'Да' : 'Нет' }}</td>
            <td>{{ $item->progName }}</td>
            <td>
                @if (!empty($item->courseDirection->name))
                {{ $item->courseDirection->name }}
                @endif
            </td>
            <td>
                @if (!empty($item->idTypeDoc))
                {{ $item->courseTypeDoc->name }}
                @endif 
            </td>
            <td>
                @if (!empty($item->dateDoc))
                {{ date('d.m.Y', strtotime($item->dateDoc))}}
                @endif
            </td>
            <td>
                {{ date('d.m.Y', strtotime($item->updated_at))}}
            </td>
        </tr>
        @endforeach
    </tbody>

</table>