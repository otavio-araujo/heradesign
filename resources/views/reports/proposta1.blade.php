<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>Header and Footer example</title>
    <style type="text/css">
        @page {
            margin: 0;
        }

        body {
            font-family: sans-serif;
            margin-top: 180px;
            margin-bottom: 30px;
            text-align: justify;
            counter-reset: page;
        }

        #lineup {
            background: #BD986E;
            height: 2mm;
        }

        #header,
        #footer {
            position: fixed;
            left: 0;
            right: 0;
            color: #aaa;
            font-size: 0.9em;
        }

        #header {
            top: 0;

        }

        #footer {
            bottom: 0;
            border-top: 0.1pt solid #aaa;
        }

        #header table,
        #footer table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        #header td,
        #footer td {
            padding: 0;
            width: 50%;
        }

        .container {
            margin: 0 20mm;
        }

        .page-number {
            text-align: center;
            background: #09204A;
            padding: 2mm;
            font-size: 8pt;
            color: white;
        }

        .page-number:after {
            content: "Página: "counter(page);
        }

        hr {
            page-break-after: always;
            border: 0;
        }

        .titulo {
            border-left: 0.5rem solid #BD986E;
            padding-left: 0.5rem;
            color: #09204A;
        }

        p {
            font-size: 12pt;
            color: #6a6a6a;
        }

        .dados-cliente {
            border-bottom: 0.1pt solid #09204A; 
            border-top: 0.1pt solid #09204A;
            /* border-left: 0.1pt solid #09204A; 
            border-right: 0.1pt solid #09204A;
            border-radius: 5px; */
            padding: 0.5rem;
            font-size: 10pt;
        }

    </style>

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
            <div
                style="display: inline-block; background-color: #09204A ; padding: 4px 10px; border-radius: 3px; font-size: 9pt; color: white;">
                Proposta: 000.000.001</div>
            <div
                style="margin: 0 0.5rem; display: inline-block; background-color: #09204A ; padding: 4px 10px; border-radius: 3px; font-size: 9pt; color: white;">
                Emitida em: 08/06/2022</div>
            <div
                style="display: inline-block; background-color: #09204A ; padding: 4px 10px; border-radius: 3px; font-size: 9pt; color: white;">
                Validade até: 08/07/2022</div>
        </div>
    </div>

    <div id="footer">
        <div class="page-number">Hera Desing - Cabeceiras Sob Medida - </div>
    </div>

    <div class="container">

        <div class="dados-cliente">
            <table>
                <tr>
                    <td align="right" width="50px"><b>Cliente:</b></td>
                    <td colspan="3">Otávio Araújo</td>
                    <td align="right"><b>Parceiro:</b></td>
                    <td>Hera Design</td>
                </tr>
                <tr>
                    <td align="right"><b>Endereço:</b></td>
                    <td colspan="5">Rua Rubens Sebastião Marin, 1076 - Apto 2001 - Torre Sky</td>
                    
                </tr>
                <tr>
                    <td align="right"><b>Bairro:</b></td>
                    <td>Parque Industrial</td>
                    <td align="right"><b>Cidade:</b></td>
                    <td>Santo Antonio da Platina</td>
                    <td align="right"><b>Estado:</b></td>
                    <td>PR</td>
                </tr>
                <tr>
                    <td align="right"><b>Telefone:</b></td>
                    <td>(44) 99119-0655</td>
                    <td align="right"><b>Email:</b></td>
                    <td>otavio_araujo@hotmail.com</td>
                </tr>
            </table>
        </div>

        <h2 class="titulo">A História das Cabeceiras</h2>

        <p>
            As cabeceiras tem sido uma parte importante dos leitos desde os tempos antigos, sendo útil em vários
            sentidos como conforto, isolamento e decoração.
        </p>

        <p>
            Os antigos gregos, por exemplo, não apenas DORMIAM em suas
            camas – eles também jantavam e socializavam nelas, de forma que a cabeceira tornou-se um encosto.
        </p>

        <div style="text-align: center; padding: 0.5rem 0 0.5rem 0">
            <img src="{{ asset('images/cabeceiras/photo-1560184897-502a475f7a0d.webp') }}" width="320" alt="">
        </div>

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

        <div style="text-align: center; padding: 0.5rem 0 0.5rem 0">
            <img src="{{ asset('images/cabeceiras/photo-1632210702485-e1841e30752a.webp') }}" width="320" alt="">
        </div>

        <p>
            Por volta do século 19, os quartos tornaram-se particulares, de configuração íntima, mas enquanto as camas
            eram tipicamente menos
            enfeitadas do que em épocas anteriores, manteve-se como encosto cabeceiras decorativas que ancoraram a cama
            no
            quarto.
        </p>


        <p>
            No século 18, Thomas Chippendale recomendou
            que se cobrisse uma cabeceira no mesmo tecido que as cortinas da cama. Ao final do século 19, cabeceiras
            foram comumente cobertas de estofos em tufos. Um guia de estofador de 1890, por exemplo, mostra uma cama de
            dossel com botão de acolchoamento na cabeceira da cama como uma alternativa simples, mas à moda de festões
            de fantasia e tapeçaria.
        </p>

        <p>
            Ao longo do século 20, cabeceiras estofadas foram favorecidas como um luxo
            decorativo, mas confortável, um vestígio dos drapeados elaborados que, uma vez enquadraram as mais elegantes
            camas.
        </p>

        <p>
            As camas e cabeceiras de hoje podem até não ser mais o centro da casa como nos tempos antigos, mas elas
            continuam tendo multitarefas, como encostar nossas cabeças com notebooks, livros sobre os nossos joelhos ou
            até fazer um lanchinho vez ou outra.
        </p>

        <div style="text-align: center; padding: 1rem 0 0.5rem 0;">
            <img src="{{ asset('images/cabeceiras/istockphoto-174863356-612x612.jpg') }}" width="400" alt="">
        </div>

        <div style="text-align: center; padding: 60px 0 0.5rem 0;">
            <img src="{{ asset('images/cabeceiras/istockphoto-834429368-612x612.jpg') }}" width="300" alt="" style="margin-right: 20px;">
            <img src="{{ asset('images/cabeceiras/istockphoto-857618074-612x612.jpg') }}" width="300" alt="">
        </div>


    </div>

</body>

</html>
