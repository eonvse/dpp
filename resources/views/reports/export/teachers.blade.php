<table >
    <thead >
        <tr>
            <th colspan="11">АИС "Мониторинг ДПП". Отчет по педагогам.</th>
        </tr>
        @if (!empty($filter))        
        <tr>
            <th colspan="11">{{ implode('.',$filter) }}</th>
        </tr>
        @endif
        <tr>
            <th >Фамилия</th>
            <th >Имя</th>
            <th >Отчество</th>
            <th >Должность</th>
            <th >Место работы</th>
            <th colspan="2" >Всего курсов ДПП (часов)</th>
            <th colspan="2" >Курсов ДПП в Фед. реестре (часов)</th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
    <tr>
        <td>{{ $item->surname }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->patronymic }}</td>
        <td>
            @if (!empty($item->idPositions))
            {{ $item->position->name }}
            @endif
        </td>
        <td>
            @if (!empty($item->idInstitutions))
            {{ $item->institution->fullname }}
            @endif
        </td>
        <td>{{ $item->courses->count('id') }}</td>
        <td>{{ $item->courses->sum('hours') }}</td>
        <td>{{ $item->courses->sum('isFederal') }}</td>
        <td>{{ $item->courses->where('isFederal','>','0')->sum('hours')}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
