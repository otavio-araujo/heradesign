@php
    use Carbon\Carbon;
    use App\Helpers\Helpers;
@endphp
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
                            46.539.802/0001-75 | (44) 99119-0655 | (44) 99760-7805
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
                Proposta: {{ Helpers::setProposalNumber($data->id) }}
            </div>
            <div class="badge-topo-hera ml-5px mr-5px">
                Emitida em: {{ Carbon::parse($data->created_at)->format('d/m/Y') }}
            </div>
            <div class="badge-topo-hera">
                Validade até: {{ Carbon::parse($data->created_at)->addDays($data->dias_validade)->format('d/m/Y') }}
            </div>
        </div>
    </div>

    <div id="footer">
        <table>
            <tr>
                <td></td>
                <td>
                    <div>
                        <img src="{{ asset('images/logo-middle-white.png') }}" height="30">
                    </div>
                </td>
                <td><div class="page-number"></div></td>
            </tr>
        </table> 
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
                            <div>{{ $data->customer->nome }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>CPF:</strong></div>
                            <div>{{ $data->customer->pf_customer[0]->cpf }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>PARCEIRO:</strong></div>
                            <div>{{ $data->customer->parceiro->nome }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="pb-3px">
                            <div class="label"><strong>endereço:</strong></div>
                            <div>{{ $data->customer->endereco }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>número:</strong></div>
                            <div>{{ $data->customer->numero }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>complemento:</strong></div>
                            <div>{{ $data->customer->complemento }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="pb-3px">
                            <div class="label"><strong>BAIRRO:</strong></div>
                            <div>{{ $data->customer->bairro }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>CIDADE:</strong></div>
                            <div>{{ $data->customer->cidade->nome }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>ESTADO:</strong></div>
                            <div>{{ $data->customer->cidade->estado->uf }}</div>
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
                            <div>{{ $data->customer->whatsapp }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>telefone:</strong></div>
                            <div>{{ $data->customer->telefone }}</div>
                        </td>
                        <td>
                            <div class="label"><strong>celular:</strong></div>
                            <div>{{ $data->customer->celular }}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <div class="label"><strong>email:</strong></div>
                            <div>{{ $data->customer->email }}</div>
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

        <hr/>

        @php
            $count_cabeceiras = 1;
        @endphp
        @if ($data->headboards->count() > 0)
        <h2 class="titulo" style="margin-top: 2rem;">cabeceiras</h2>
        
            @foreach ($data->headboards as $headboard)
            <div class="card mb-15px">
                <div class="card-header">
                    <h2>Cabeceira - {{ $count_cabeceiras }}</h2>
                </div>
                <div class="card-body">

                    <table style="width: 100%;">

                        <tr>
                            <td colspan="2">
                                <div class="label"><strong>Quantidade:</strong></div>
                                <div>{{ $headboard->qtd }}</div>
                            </td>
                            <td class="pb-3px">
                                <div class="label"><strong>Valor Unitário:</strong></div>
                                <div>R${{ number_format($headboard->valor_unitario, 2, ',', '.') }}</div>
                            </td>
                            <td>
                                <div class="label"><strong>Valor Total:</strong></div>
                                <div>R${{ number_format($headboard->valor_total, 2, ',', '.') }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"><div class="separator"></div></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="label"><strong>tecido escolhido:</strong></div>
                                <div>{{ $headboard->tecido }}</div>
                            </td>
                            <td class="pb-3px">
                                <div class="label"><strong>LARGURA (mm):</strong></div>
                                <div>{{ $headboard->largura }}</div>
                            </td>
                            <td>
                                <div class="label"><strong>altura (mm):</strong></div>
                                <div>{{ $headboard->altura }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"><div class="separator"></div></td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <div class="label"><strong>observações da cabeceira:</strong></div>
                                <div>{{ $headboard->obs_headboard }}.</div>
                            </td>
                        </tr>

                        <tr>
                            <td style="padding: 7px;"></td>
                        </tr>

                        <tr>
                            <td colspan="4">
                                <div class="card mb-15px">
                                    <div class="card-header">
                                        <h2>customizações</h2>
                                    </div>
                                    <div class="card-body">
                                        <table style="width: 100%;">
                        
                                            <tr>
                                                <td>
                                                    <div class="label"><strong>FITAS DE LED:</strong></div>
                                                    <div>{{ $headboard->has_led === true ? 'Sim' : 'Não'; }}</div>  
                                                </td>
                                                <td></td>
                                                @if ($headboard->has_led === true)
                                                <td style="width: 50%;" colspan="2">
                                                    <div class="label"><strong>DETALHES:</strong></div>
                                                    <div>{{ $headboard->obs_led }}</div>
                                                </td>
                                                @endif
                                                
                                            </tr>
                        
                                            <tr>
                                                <td colspan="4"><div class="separator"></div></td>
                                            </tr>
                        
                                            <tr>
                                                <td>
                                                    <div class="label"><strong>SEPARADORES:</strong></div>
                                                    <div>{{ $headboard->has_separador === true ? 'Sim' : 'Não'; }}</div>
                                                </td>
                                                <td></td>
                                                @if ($headboard->has_separador === true)
                                                <td colspan="2">
                                                    <div class="label"><strong>DETALHES:</strong></div>
                                                    <div>{{ $headboard->obs_separador }}</div>
                                                </td>
                                                @endif
                                            </tr>
                        
                                            <tr>
                                                <td colspan="4"><div class="separator"></div></td>
                                            </tr>
                        
                                            <tr>
                                                <td>
                                                    <div class="label"><strong>TOMADAS:</strong></div>
                                                    <div>{{ $headboard->has_tomada === true ? 'Sim' : 'Não'; }}</div>
                                                </td>
                                                @if ($headboard->has_tomada === true)
                                                <td>
                                                    <div class="label"><strong>QUANTIDADE:</strong></div>
                                                    <div>{{ $headboard->qtd_tomada }}</div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="label"><strong>DETALHES:</strong></div>
                                                    <div>{{ $headboard->obs_tomada }}</div>
                                                </td>
                                                @endif
                                            </tr>
                        
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4">
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
                                            @foreach ($headboard->modules as $modulo)
                                                
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
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            @php
                $count_cabeceiras++;
            @endphp
            @endforeach
        
        @endif

        @php
            $count_items = 1;
        @endphp
        @if ($data->proposalItems->count() > 0)
        <h2 class="titulo" style="margin-top: 2rem;">outros ítens</h2>
        
            @foreach ($data->proposalItems as $item)
            <div class="card mb-15px">
                <div class="card-header">
                    <h2>Ítem - {{ $count_items }}</h2>
                </div>
                <div class="card-body">

                    <table style="width: 100%;">

                        <tr>
                            <td colspan="4" style="padding-bottom: 5px;">
                                <div class="label"><strong>Descrição:</strong></div>
                                <div>{{ $item->descricao }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"><div class="separator"></div></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="padding-bottom: 5px;">
                                <div class="label"><strong>Quantidade:</strong></div>
                                <div>{{ $item->qtd }}</div>
                            </td>   
                            <td style="padding-bottom: 5px;">
                                <div class="label"><strong>Valor Unitário:</strong></div>
                                <div>R${{ number_format($item->valor_unitario, 2, ',', '.') }}</div>
                            </td>
                            <td>
                                <div class="label"><strong>Valor Total:</strong></div>
                                <div>R${{ number_format($item->valor_total, 2, ',', '.') }}</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4"><div class="separator"></div></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4">
                                <div class="label"><strong>Observações do Ítem:</strong></div>
                                <div>{{ $item->obs_item }}</div>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            @php
                $count_items++;
            @endphp
            @endforeach
        
        @endif
        


        <h2 class="titulo" style="margin-top: 2rem;">prazo de entrega</h2>
        
        <p style="margin-left: 30px; color: #434343;">{{ $data->prazo_entrega }} dias da data de aprovação.</p>

        @if ($data->observacoes != '')
        <h2 class="titulo" style="margin-top: 3rem;">outras observações</h2>

        <div style="margin-bottom: 4rem; color: #6a6a6a;">
            {!! $data->observacoes !!}
        </div>
       
        @endif

        

        <h2 class="titulo" style="margin-top: 2rem;">valor total da proposta</h2>

        @if ($data->headboards->count() > 0)
        <div class="card" style="margin-bottom: 15px !important;">
            <div class="card-header">
                <h2>DETALHAMENTO de cabeceiras</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr class="th">
                        <td class="pb-3px pl-5px text-center">
                            <div><strong>#</strong></div>
                            
                        </td>
                        <td>
                            <div><strong>Descrição</strong></div>
                            
                        </td>
                        <td style="text-align: center !important;">
                            <div><strong>Quantidade</strong></div>
                        
                        </td>
                        <td style="text-align: center !important;">
                            <div><strong>Valor Unitário</strong></div>
                        
                        </td>
                        <td style="text-align: center !important;">
                            <div><strong>Valor Total</strong></div>
                        </td>
                    </tr>
                    
                    @foreach ($data->headboards as $headboard)
                        
                    <tr class="{{ $loop->even ? 'tr-bg-hera' : ''; }} {{ $loop->last ? 'tr-last' : ''; }}">
                        <td class="pb-3px pl-5px">
                            <div class="label text-center" style="width: 100%;">{{ $loop->iteration }}</div> 
                        </td>
                        <td>
                            <div class="label">Cabeceira - {{ $loop->iteration }}</div> 
                        </td>
                        <td>
                            <div class="label" style="text-align: center !important;">{{ $headboard->qtd }}</div> 
                        </td>
                        <td>
                            <div class="label" style="text-align: center !important;">R${{ number_format($headboard->valor_unitario, 2, ',', '.') }}</div> 
                        </td>
                        <td>
                            <div class="label">R${{ number_format($headboard->valor_total, 2, ',', '.') }}</div> 
                        </td>
                    </tr>

                        
                    @endforeach

                    <tr class="total">
                        <td colspan="4" style="text-align: right !important;"><strong>Total em Cabeceiras:</strong></td>
                        <td style="text-align: center !important;"> R${{ number_format($data->headboards->sum('valor_total'), 2, ',', '.') }}</td>
                    </tr>

                </table>
            </div>
        </div>
        @else
        <div class="card" style="margin-bottom: 15px !important;">
            <div class="card-header">
                <h2>DETALHAMENTO de cabeceiras</h2>
            </div>
            <div class="card-body">
                Sem Cabeceiras.
            </div>
        </div>
        @endif

        @if ($data->proposalItems->count() > 0)
        <div class="card" style="margin-bottom: 15px !important;">
            <div class="card-header">
                <h2>DETALHAMENTO de outros ítens</h2>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr class="th">
                        <td class="pb-3px pl-5px text-center">
                            <div><strong>#</strong></div>
                            
                        </td>
                        <td>
                            <div><strong>Descrição</strong></div>
                            
                        </td>
                        <td style="text-align: center !important;">
                            <div><strong>Quantidade</strong></div>
                        
                        </td>
                        <td style="text-align: center !important;">
                            <div><strong>Valor Unitário</strong></div>
                        
                        </td>
                        <td style="text-align: center !important;">
                            <div><strong>Valor Total</strong></div>
                        </td>
                    </tr>
                    
                    @foreach ($data->proposalItems as $item)
                        
                    <tr class="{{ $loop->even ? 'tr-bg-hera' : ''; }} {{ $loop->last ? 'tr-last' : ''; }}">
                        <td class="pb-3px pl-5px">
                            <div class="label text-center" style="width: 100%;">{{ $loop->iteration }}</div> 
                        </td>
                        <td>
                            <div class="label">Ítem - {{ $loop->iteration }}</div> 
                        </td>
                        <td>
                            <div class="label" style="text-align: center !important;">{{ $item->qtd }}</div> 
                        </td>
                        <td>
                            <div class="label" style="text-align: center !important;">R${{ number_format($item->valor_unitario, 2, ',', '.') }}</div> 
                        </td>
                        <td>
                            <div class="label">R${{ number_format($item->valor_total, 2, ',', '.') }}</div> 
                        </td>
                    </tr>

                        
                    @endforeach

                    <tr class="total">
                        <td colspan="4" style="text-align: right !important;"><strong>Total em Outros Ítens:</strong></td>
                        <td style="text-align: center !important;"> R${{ number_format($data->proposalItems->sum('valor_total'), 2, ',', '.') }}</td>
                    </tr>

                </table>
            </div>
        </div>
        @else
        <div class="card" style="margin-bottom: 15px !important;">
            <div class="card-header">
                <h2>DETALHAMENTO de outros ítens</h2>
            </div>
            <div class="card-body">
                Sem Outros Ítens.
            </div>
        </div>
        @endif

        <div class="card" style="margin-bottom: 15px !important;">
            <div class="card-header">
                <h2>TOTAL GERAL DA PROPOSTA</h2>
            </div>
            <div class="card-body">
                <p style="color: #434343; text-align: center !important;">
                    <strong>R${{ number_format($data->headboards->sum('valor_total') + $data->proposalItems->sum('valor_total') , 2, ',', '.')  }}</strong>
                </p>
            </div>
        </div>
        
        @if (!empty($data->pgto_vista) or !empty($data->pgto_boleto) or !empty($data->pgto_cartao) or !empty($data->pgto_outros))
        <h2 class="titulo" style="margin-top: 2rem;">Formas de pagamento</h2>
        
        <ul style="color: #434343;">


            @if (!empty($data->pgto_vista))
                <li class="p-3px text-secondary">
                    <strong class="text-primary">Á VISTA: </strong> 
                    {{  $data->pgto_vista }};
                </li>
            @endif

            @if (!empty($data->pgto_boleto))
                <li class="p-3px text-secondary">
                    <strong class="text-primary">BOLETO BANCÁRIO: </strong> 
                    {{  $data->pgto_boleto }};
                </li>
            @endif

            @if (!empty($data->pgto_cartao))
                <li class="p-3px text-secondary">
                    <strong class="text-primary">CARTÕES DE CRÉDITO: </strong> 
                    {{  $data->pgto_cartao }};
                </li>
            @endif

            @if (!empty($data->pgto_outros))
                <li class="p-3px text-secondary">
                    <strong class="text-primary">OUTROS: </strong> 
                    {{  $data->pgto_outros }};
                </li>
            @endif

        </ul>
        @endif
        

        {{-- <div style="padding: 20px 20px 20px 20px; text-align: center;">
            <img src="{{ asset('images/logo-middle-white.png') }}" height="30">
        </div> --}}

    </div>

</body>

</html>
