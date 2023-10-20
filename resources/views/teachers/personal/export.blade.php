<table class="table-auto my-3">
    <thead>
        <tr>
            <th colspan="7">АИС "Мониторинг ДПП". Персональные курсы.</th>
        </tr>    
        <tr>
            <th>Фамилия</th>
            <th colspan="6">
            {{ $data->surname }}
            </th>
        </tr>
        <tr>
            <th>Имя</th>
            <th colspan="6">
            {{ $data->name  }}
            </th>
        </tr>
        <tr>
            <th>Отчество</th>
            <th colspan="6">
            {{ $data->patronymic }}
            </th>
        </tr>
        <tr>
            <th>Должность</th>
            <th colspan="6">
            {{ !empty($data->position->name) ? $data->position->name : '' }}  
            </th>
        </tr>
        <tr>
            <th>Учреждение</th>
            <th colspan="6">
            {{ !empty($data->institution->name) ? $data->institution->name : '' }}  
            </th>
        </tr>
        <tr>
            <th>Документ об образовании</th>
            <th colspan="6">
            {{ !empty($data->document->name) ? $data->document->name : '' }}  
            </th>
        </tr>
        <tr>
            <th>Дата получения</th>
            <th colspan="6">
            {{ !empty($data->dateDoc) ? date('d.m.Y', strtotime($data->dateDoc)) : '' }}
            </th>
        </tr>
        <tr><th></th></tr>
    </thead>
    <tbody>
        <tr>
            <td>Наименование ОУ</td>
            <td>Наименование ДПП</td>
            <td>Дата получения</td>
            <td>Часов</td>
            <td>Тип ДПП</td>
            <td>Входит<br /> в Федеральный реестр</td>
            <td>Направление ДПП</td>
        </tr>
        @foreach ($data->courses()->orderBy('progName')->get() as $item)        
        <tr>
            <td>{{ $item->fullName}}</td>
            <td>{{ $item->progName}}</td>
            <td>{{ !empty($item->dateDoc) ? date('d.m.Y', strtotime($item->dateDoc)) : '' }}</td>
            <td>{{ $item->hours}}</td>
            <td>{{ !empty($item->courseType->name) ? $item->courseType->name : '' }}</td>
            <td>{{ !empty($item->isFederal) ? 'Да' : 'Нет' }}</td>
            <td>{{ !empty($item->courseDirection->name) ? $item->courseDirection->name : '' }}</td>
        </tr>

        @endforeach
    </tbody>
</table>
