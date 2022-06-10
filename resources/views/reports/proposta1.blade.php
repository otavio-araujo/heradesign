<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>PT-{{ $data->id }}</title>


    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">


</head>

<body>


    <div id="header">
        <div id="lineup"></div>

        <table style="border-bottom: 0.1pt solid #ebd7bf">
            <tr>
                <td style="text-align: center;">
                    <div style="padding: 20px">
                        <img src="{{ asset('images/logo-middle-white.png') }}" height="50">
                    </div>
                    <div style="color:#909090; font-size: 8pt; margin-bottom: 0.5rem;">
                        <address>
                            21.296.142/0001-18 | (44) 99119-0655 | (44) 99760-7805
                        </address>
                        <address>
                            Rua Rio Taperoá, 464 - Jardim Novo Oasis, Maringá - PR, 87043-290
                        </address>
                    </div>

                </td>
            </tr>
        </table>
        <div style="text-align: center; margin: 1rem 0 0 0;">
            <div class="badge-topo-hera">
                Proposta: 000.000.001
            </div>
            <div class="badge-topo-hera ml-5px mr-5px">
                Emitida em: 08/06/2022
            </div>
            <div class="badge-topo-hera">
                Validade até: 08/07/2022
            </div>
        </div>
    </div>

    <div id="footer">
        <div class="page-number">Hera Desing - Cabeceiras Sob Medida - </div>
    </div>

    <div class="container">

        <div class="card mb-15px">
            <div class="card-header">
                <h2>cadastro do cliente</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2" class="pb-3px">
                            <div class="label"><strong>NOME:</strong></div>
                            <div>{{ $data->cliente->nome }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>CPF:</strong></div>
                            <div>{{ $data->cliente->pf_customer[0]->cpf }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>PARCEIRO:</strong></div>
                            <div>{{ $data->cliente->parceiro->nome }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="pb-3px">
                            <div class="label"><strong>endereço:</strong></div>
                            <div>{{ $data->cliente->endereco }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>número:</strong></div>
                            <div>{{ $data->cliente->numero }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>complemento:</strong></div>
                            <div>{{ $data->cliente->complemento }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="pb-3px">
                            <div class="label"><strong>BAIRRO:</strong></div>
                            <div>{{ $data->cliente->bairro }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>CIDADE:</strong></div>
                            <div>{{ $data->cliente->cidade->nome }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>ESTADO:</strong></div>
                            <div>{{ $data->cliente->cidade->estado->uf }}</div>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>CONTATOs</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">

                    <tr>
                        <td colspan="2" class="pb-3px">
                            <div class="label"><strong>whatsapp:</strong></div>
                            <div>{{ $data->cliente->whatsapp }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>telefone:</strong></div>
                            <div>{{ $data->cliente->telefone }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>celular:</strong></div>
                            <div>{{ $data->cliente->celular }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <div class="label"><strong>email:</strong></div>
                            <div>{{ $data->cliente->email }}</div>
                        </td>
                    </tr>

                </table>
            </div>
        </div>



        <h2 class="titulo" style="margin-top: 2rem;">UM POUQUINHO DE HISTÓRIA</h2>

        <p>
            As cabeceiras tem sido uma parte importante dos leitos desde os tempos antigos, sendo útil em vários
            sentidos como conforto, isolamento e decoração.
        </p>

        <p>
            Os antigos gregos, por exemplo, não apenas DORMIAM em suas
            camas – eles também jantavam e socializavam nelas, de forma que a cabeceira tornou-se um encosto.
        </p>

        <p>
            Isso
            também aconteceu no renascimento, quando a cama foi a principal peça do mobiliário e do centro social da
            casa. Em climas do norte ( no caso do Brasil seria sul e sudeste ), as cabeceiras de cama também ajudaram a
            proteger as pessoas de correntes de ar em noites frias.
        </p>

        <p>
            Na Idade Média, a cabeceira da cama havia se tornado uma importante oportunidade de decoração para
            esculturas
            elaboradas, painéis arquitetônicos, ou tapeçaria suntuosa. William Shakespeare deixou a sua famosa “segunda
            melhor cama” para a mulher em seu testamento, um legado que foi menos mesquinho do que parece, já que as
            camas
            elisabetanas eram bens muitas vezes significativos: Dosséis arquitetônicos com cabeceiras esculpidas (embora
            estejamos apostando que ela poderia ter royalties preferenciais em Romeu e Julieta).
        </p>

        <p>
            Por volta do século 19, os quartos tornaram-se particulares, de configuração íntima, mas enquanto as camas
            eram tipicamente menos
            enfeitadas do que em épocas anteriores, manteve-se como encosto cabeceiras decorativas que ancoraram a cama
            no
            quarto.
        </p>

        <p>
            No século 18, Thomas Chippendale recomendou
            que se cobrisse uma cabeceira no mesmo tecido que as cortinas da cama.
        </p>

        <p>Ao final do século 19, cabeceiras
            foram comumente cobertas de estofos em tufos. Um guia de estofador de 1890, por exemplo, mostra uma cama de
            dossel com botão de acolchoamento na cabeceira da cama como uma alternativa simples, mas à moda de festões
            de fantasia e tapeçaria.
        </p>

        <div style="text-align: center; padding: 50px 0 .1rem 0; margin: 0;">
            <img src="{{ asset('images/cabeceiras/photo-1632210702485-e1841e30752a.webp') }}" height="185" alt=""
                style="margin-right: 20px;">
            <img src="{{ asset('images/cabeceiras/photo-1560184897-502a475f7a0d.webp') }}" height="180" alt="">
        </div>

        <p style="margin-top: -12px;">
            Ao longo do século 20, cabeceiras estofadas foram favorecidas como um luxo
            decorativo, mas confortável, um vestígio dos drapeados elaborados que, uma vez enquadraram as mais elegantes
            camas.
        </p>

        <p>
            As camas e cabeceiras de hoje podem até não ser mais o centro da casa como nos tempos antigos, mas elas
            continuam tendo multitarefas, como encostar nossas cabeças com notebooks, livros sobre os nossos joelhos ou
            até fazer um lanchinho vez ou outra.
        </p>

        <div style="text-align: center; padding: .75rem 0 0.5rem 0;">
            <img src="{{ asset('images/cabeceiras/istockphoto-174863356-612x612.jpg') }}" width="260" alt="">
        </div>

        <div style="text-align: center; padding: 50px 0 0 0;">
            <img src="{{ asset('images/cabeceiras/istockphoto-834429368-612x612.jpg') }}" width="260" alt=""
                style="margin-right: 20px;">
            <img src="{{ asset('images/cabeceiras/istockphoto-857618074-612x612.jpg') }}" width="260" alt="">
        </div>

        <div></div>

        <h2 class="titulo" style="margin-top: 2rem;">DETALHES DA PROPOSTA</h2>

        <div class="card mb-15px">
            <div class="card-header">
                <h2>DADOS GERAIS DO PROJETO</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">

                    <tr>
                        <td colspan="2">
                            <div class="label"><strong>tecido escolhido:</strong></div>
                            <div>{{ $data->tecido }}</div>
                        </td>
                        <td class="pb-3px">
                            <div class="label"><strong>LARGURA (mm):</strong></div>
                            <div>{{ $data->largura }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>altura (mm):</strong></div>
                            <div>{{ $data->altura }}</div>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="card mb-15px">
            <div class="card-header">
                <h2>customizações</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">

                    <tr>
                        <td style="width: 50%;">
                            <div class="label"><strong>FITAS DE LED:</strong></div>
                            <div>{{ true === (bool)$data->tecido ? 'Sim' : 'Nao'; }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>SEPARADORES METÁLICOS:</strong></div>
                            <div>{{ true === (bool)$data->separadores ? 'Sim' : 'Nao'; }}</div>
                        </td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>módulos</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr class="th">
                        <td class="pb-3px pl-5px text-center">
                            <div><strong>#</strong></div>
                            
                        </td>
                        <td>
                            <div><strong>qtd</strong></div>
                            
                        </td>
                        <td>
                            <div><strong>largura (mm)</strong></div>
                        
                        </td>
                        <td>
                            <div><strong>altura (mm)</strong></div>
                        
                        </td>
                        <td>
                            <div><strong>formato</strong></div>
                        </td>
                    </tr>
                    @foreach ($data->modulos as $modulo)
                        
                    <tr class="{{ $loop->even ? 'tr-bg-hera' : ''; }} {{ $loop->last ? 'tr-last' : ''; }}">
                        <td class="pb-3px pl-5px">
                            <div class="label text-center" style="width: 100%;">{{ $loop->iteration }}</div> 
                        </td>
                        <td>
                            <div class="label">{{ $modulo->quantidade }}</div> 
                        </td>
                        <td>
                            <div class="label">{{ $modulo->largura }}</div> 
                        </td>
                        <td>
                            <div class="label">{{ $modulo->altura }}</div> 
                        </td>
                        <td>
                            <div class="label">{{ $modulo->formato }}</div> 
                        </td>
                    </tr>

                        
                    @endforeach

                </table>
            </div>
        </div>

        <h2 class="titulo" style="margin-top: 2rem;">prazo de entrega</h2>
        
        <p style="margin-left: 30px; color: #434343;">{{ $data->prazo_entrega }} dias da data de aprovação.</p>

        <h2 class="titulo" style="margin-top: 2rem;">valor total da proposta</h2>
        
        <p style="margin-left: 30px; color: #434343;"><strong>R$ {{ number_format($data->valor_total, 2, ',', '.') }}.</strong></p>

        <h2 class="titulo" style="margin-top: 2rem;">Formas de pagamento</h2>
        
        <ul style="color: #434343;">
            <li class="p-3px text-secondary"><strong class="text-primary">Á VISTA: </strong> 5% de desconto no Pix / Depósito / Transferência / Débito; </li>
            <li class="p-3px text-secondary"><strong class="text-primary">PARCELADO - BOLETO: </strong> Até 3x sem juros; </li>
            <li class="p-3px text-secondary"><strong class="text-primary">PARCELADO - CARTÕES: </strong> Até 12x de R$267,87. </li>
        </ul>

        <div style="padding: 80px 20px 20px 20px; text-align: center;">
            <img src="{{ asset('images/logo-middle-white.png') }}" height="30">
        </div>

    </div>

</body>

</html>
