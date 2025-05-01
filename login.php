<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICLOM Operacional - Sistema de controle logístico de fórmula infantil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <form>
            <div action="login.php" method="POST" style="background-color: rgb(245, 245, 245); padding: 17px; border-radius: 7px;">
                <!---->
                <img src="/images/siclofi.png" style="display: block; margin: auto; height: 60px;">
                <p class="loginpcont">Faça login para continuar</p>

                <select class="form-control" name="uf" id="uf">
                    <option value="">UF</option>
                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AM">AM</option>
                    <option value="AP">AP</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="DF">DF</option>
                    <option value="ES">ES</option>
                    <option value="GO">GO</option>
                    <option value="MA">MA</option>
                    <option value="MG">MG</option>
                    <option value="MS">MS</option>
                    <option value="MT">MT</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="PR">PR</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="RS">RS</option>
                    <option value="SC">SC</option>
                    <option value="SE">SE</option>
                    <option value="SP">SP</option>
                    <option value="TO">TO</option>
                    <option value="UD">UD</option>
                </select>

                <br>

                <select class="form-control" name="udm" id="udm">
                    <option value="">Unidade</option>
                    <option value="178">ANGRA DOS REIS - CENTRO DE ESPECILIDADES MÉDICAS - ANGRA DOS</option>
                    <option value="519">ARARUAMA - COORDENAÇÃO DE SAUDE COLETIVA DE ARARUAMA</option>
                    <option value="832">AREAL - FARMÁCIA MUNICIPAL DRº SAINT CLAIR SOARES SENNA - AREAL</option>
                    <option value="126">ARRAIAL DO CABO - SECRETARIA MUNICIPAL DE SAÚDE - ARRAIAL DO</option>
                    <option value="124">BARRA DO PIRAÍ - FARMACIA MUNICIPAL</option>
                    <option value="256">BARRA MANSA - SECRETARIA MUNICIPAL DE BARRA MANSA</option>
                    <option value="056">BELFORD ROXO - CACE - BENIS PEREIRA DE FREITAS - BELFORD ROXO</option>
                    <option value="125">BOM JESUS DO ITABAPOANA - CENTRO DE SAÚDE DR. JOSÉ VIEIRA SE</option>
                    <option value="582">BÚZIOS - DEPARTAMENTO DE SAÚDE COLETIVA DE ARMAÇÃO DOS BÚZIO</option>
                    <option value="123">CABO FRIO - HOSPITAL DIA DO HOSPITAL SÃO JOSÉ OPERARIO</option>
                    <option value="809">CACHOEIRAS DE MACACU - AMBULATORIO PADRE BATALHA</option>
                    <option value="I95">CADEIA PÚBLICA JUIZA DE DIREITO PATRICIA ACIOLI</option>
                    <option value="127">CAMPOS DOS GOYTACAZES - SAE-CTA - PROGRAMA MUNICIPAL DST/AID</option>
                    <option value="394">CASIMIRO DE ABREU - SECRETARIA MUNICIPAL DE SAÚDE DE CASIMIR</option>
                    <option value="065">CENTRO DE REFERENCIA E TESTAGEM GONÇALENSE</option>
                    <option value="K19">CENTRO DE SAÚDE COLETIVA PROFESSOR MANOEL JOSÉ FERREIRA</option>
                    <option value="B08">CER BARRA - CAP 40</option>
                    <option value="B07">CER CENTRO CAP 10</option>
                    <option value="B22">CER ILHA (EVANDRO FREIRE) CAP 31</option>
                    <option value="B61">CER LEBLON CAP 21</option>
                    <option value="B23">CLINICA DA FAMÍLIA DOUTOR ZERBINI</option>
                    <option value="177">CORDEIRO - FUNDO MUNICIPAL DE SAÚDE DE CORDEIRO</option>
                    <option value="337">CSE GERMANO SINVAL FARIA - AP 31</option>
                    <option value="057">DUQUE DE CAXIAS - CENTRO MUNICIPAL DE SAÚDE DE D. DE CAXIAS</option>
                    <option value="485">GUAPIMIRIM - POSTO DE SAÚDE MUNICIPAL JOÃO ARRUDA</option>
                    <option value="523">HOSPITAL CENTRAL DA POLÍCIA MILITAR AP 10</option>
                    <option value="347">HOSPITAL CENTRAL DO EXÉRCITO - AP 32</option>
                    <option value="A59">HOSPITAL DA MÃE DE MESQUITA</option>
                    <option value="A55">HOSPITAL DA MULHER HELONEIDA STUDART</option>
                    <option value="A97">HOSPITAL DA MULHER MARISKA RIBEIRO - AP 51</option>
                    <option value="063">HOSPITAL DA POSSE - HOSPITAL GERAL DE NOVA IGUAÇU</option>
                    <option value="348">HOSPITAL DE AERONÁUTICA DOS AFONSOS - AP 51</option>
                    <option value="227">HOSPITAL ESCOLA SÃO FRANCISCO DE ASSIS - AP 10</option>
                    <option value="966">HOSPITAL ESTADUAL ADÃO PEREIRA NUNES</option>
                    <option value="060">HOSPITAL ESTADUAL AZEVÊDO LIMA</option>
                    <option value="965">HOSPITAL ESTADUAL SANTA MARIA</option>
                    <option value="037">HOSPITAL FEDERAL CARDOSO FONTES - AP 40</option>
                    <option value="035">HOSPITAL FEDERAL DA LAGOA - AP 21</option>
                    <option value="338">HOSPITAL FEDERAL DE IPANEMA - AP 21</option>
                    <option value="041">HOSPITAL FEDERAL DOS SERVIDORES DO ESTADO - AP 1.0</option>
                    <option value="A98">HOSPITAL MATERN. MARIA AMELIA BUARQUE DE HOLANDA - AP 10</option>
                    <option value="A96">HOSPITAL MATERNIDADE ALEXANDER FLEMING - AP 33</option>
                    <option value="A99">HOSPITAL MATERNIDADE CARMELA DUTRA - AP 32</option>
                    <option value="B01">HOSPITAL MATERNIDADE FERNANDO MAGALHÃES - AP 10</option>
                    <option value="B09">HOSPITAL MATERNIDADE HERCULANO PINHEIRO - AP 33</option>
                    <option value="J51">HOSPITAL MATERNIDADE PAULINO WERNECK - ILHA DO GOVERNADOR - AP 31</option>
                    <option value="B02">HOSPITAL MUNICIPAL ALBERT SCHWEITZER AP 51</option>
                    <option value="058">HOSPITAL MUNICIPAL CARLOS TORTELLY</option>
                    <option value="021">HOSPITAL MUNICIPAL DA PIEDADE - AP 32</option>
                    <option value="038">HOSPITAL MUNICIPAL JESUS - AP 22</option>
                    <option value="A95">HOSPITAL MUNICIPAL LOURENÇO JORGE - AP 40</option>
                    <option value="J96">HOSPITAL MUNICIPAL MIGUEL COUTO - AP 2.1</option>
                    <option value="A94">HOSPITAL MUNICIPAL PEDRO II - AP 53</option>
                    <option value="039">HOSPITAL MUNICIPAL RAPHAEL DE PAULA SOUZA - AP 40</option>
                    <option value="B03">HOSPITAL MUNICIPAL ROCHA FARIA AP 52</option>
                    <option value="780">HOSPITAL MUNICIPAL ROCHA MAIA AP 21</option>
                    <option value="B04">HOSPITAL MUNICIPAL SALGADO FILHO AP 32</option>
                    <option value="B05">HOSPITAL MUNICIPAL SOUZA AGUIAR AP 10</option>
                    <option value="346">HOSPITAL NAVAL MARCÍLIO DIAS - AP 32</option>
                    <option value="042">HOSPITAL UNIVERSIT. CLEMENTINO FRAGA FILHO - AP 31</option>
                    <option value="043">HOSPITAL UNIVERSIT. GAFFREÉ E GUINLE - AP 22</option>
                    <option value="044">HOSPITAL UNIVERSIT. PEDRO ERNESTO (UERJ) - AP 22</option>
                    <option value="062">HOSPITAL UNIVERSITÁRIO ANTÔNIO PEDRO</option>
                    <option value="524">IASERJ MARACANÃ</option>
                    <option value="584">IGUABA GRANDE - FARMÁCIA MUNICIPAL DE IGUABA GRANDE</option>
                    <option value="144">IMBARIÊ - POSTO MÉDICO SANITÁRIO IMBARIÊ</option>
                    <option value="755">INCA 1- INSTITUTO NACIONAL DE CÂNCER JOSÉ DE ALENCAR GOMES DA SILVA</option>
                    <option value="E65">INCA 2 - INSTITUTO NACIONAL DE CANCER JOSE ALENCAR GOMES SILVA/HCC II</option>
                    <option value="E66">INCA 3 - INSTITUTO NACIONAL DO CANCER JOSE DE ALENCAR GOMES DA SILVA</option>
                    <option value="047">INSTIT. DE PED. E PUER. MARTAGÃO GESTEIRA - AP 31</option>
                    <option value="036">INSTIT. NAC. DE INFECT. EVANDRO CHAGAS - INI</option>
                    <option value="046">INSTITUTO FERNANDES FIGUEIRA - AP 21</option>
                    <option value="176">ITABORAÍ - SAE DE DST, AIDS E HEPATITES VIRAIS</option>
                    <option value="975">ITAGUAI - DEPARTAMENTO DE SAÚDE COLETIVA DE ITAGUAI</option>
                    <option value="175">ITAPERUNA - PROGRAMA MUNICIPAL DE DST/AIDS E HEPATITES VIRAI</option>
                    <option value="255">ITATIAIA - AMBULATÓRIO CENTRAL DE ITATIAIA</option>
                    <option value="833">JAPERI - UNIDADE MISTA ENGENHEIRO PEDREIRA - JAPERI</option>
                    <option value="174">MACAÉ - PROGRAMA MUNICIPAL DST/HIV/ AIDS MACAÉ</option>
                    <option value="818">MAGÉ -SERVIÇO DE ATENDIMENTO ESPECIALIZADO EM TRATAMENTO DST</option>
                    <option value="819">MANGARATIBA - PROGRAMA MUNICIPAL DST/AIDS</option>
                    <option value="578">MARICÁ - CAF</option>
                    <option value="J55">MATERNIDADE DA ROCINHA - AP 21</option>
                    <option value="A65">MATERNIDADE ESCOLA DA UFRJ - AP 21</option>
                    <option value="A66">MATERNIDADE MUNICIPAL MARIANA BULHÕES</option>
                    <option value="H87">MATERNIDADE SANTA CRUZ DA SERRA</option>
                    <option value="815">MESQUITA - PROGRAMA MUNICIPAL DE DST/AIDS - MESQUITA</option>
                    <option value="257">MIGUEL PEREIRA - FARMACIA MUNCIPAL DE MIGUEL PEREIRA</option>
                    <option value="173">MIRACEMA - POSTO DE SAÚDE DR. IRINEU SODRÉ - MIRACEMA</option>
                    <option value="G49">NAF PRISIONAL - ATENCAO PRIMARIA PRISIONAL AP 51</option>
                    <option value="822">NATIVIDADE - AMBULATÓRIO CENTRAL DA SECRETARIA MUNICIPAL DE</option>
                    <option value="567">NILÓPOLIS - POSTO CENTRAL DO SUS - NILÓPOLIS</option>
                    <option value="172">NOVA FRIBURGO - POLICLÍNICA CENTRO DR. SÍLVIO HENRIQUE BRAUNE</option>
                    <option value="064">NOVA IGUAÇU - CENTRO DE SAÚDE VASCO BARCELOS - NOVA IGUAÇU</option>
                    <option value="607">PARACAMBI - CENTRO MUNICIPAL DE SAÚDE COLETIVA DE PARACAMBI</option>
                    <option value="568">PARAÍBA DO SUL - CENTRO EPIDEMIO. LUCIENE PORPHIRIO ESTEVES</option>
                    <option value="834">PARATI - VIGILÂNCIA EPIDEMIOLÓGICA DE PARATI</option>
                    <option value="259">PETRÓPOLIS - PROGRAMA MUNICIPAL DE DST/AIDS E HEPATITES B E</option>
                    <option value="823">PIRAI FARMACIA MUNICIPAL </option>
                    <option value="835">POLICLINICA DE ESPECIALIDADE MALU SAMPAIO</option>
                    <option value="049">POLICLÍNICA PIQUET CARNEIRO - AP 32</option>
                    <option value="608">POLICLÍNICA REGIONAL CARLOS ANTONIO DA SILVA</option>
                    <option value="B87">POLICLÍNICA REGIONAL DA ENGENHOCA</option>
                    <option value="B99">POLICLÍNICA REGIONAL DE ITAIPU</option>
                    <option value="610">POLICLÍNICA REGIONAL DO BARRETO</option>
                    <option value="B43">POLICLINICA REGIONAL DR. GUILHERME TAYLOR MARCH</option>
                    <option value="836">POLICLINICA REGIONAL LARGO DA BATALHA</option>
                    <option value="609">POLICLÍNICA REGIONAL SÉRGIO AROUCA</option>
                    <option value="215">POLO SANITÁRIO HELIO CRUZ</option>
                    <option value="824">PORCIÚNCULA - CENTRO MUNICIPAL DE INFECTOLOGIA DE PORCIÚNCUL</option>
                    <option value="D80">PORTO REAL - FARMÁCIA MUNICIPAL DE PORTO REAL </option>
                    <option value="L20">POSTO DE SAUDE SANTA RITA</option>
                    <option value="837">QUEIMADOS - SECRETARIA MUNICIPAL DE SAÚDE DE QUEIMADOS</option>
                    <option value="171">QUISSAMÃ - CENTRO DE SAUDE BENEDITO PINTO DAS CHAGAS</option>
                    <option value="170">RESENDE - CENTRAL DE ABASTECIMENTO FARMACÊUTICO - RESENDE</option>
                    <option value="825">RIO BONITO - AMBULATÓRIO MANOEL LOYOLA DA SILVA JUNIOR</option>
                    <option value="826">RIO DAS OSTRAS - CENTRO DE SAUDE DE RIO DAS OSTRAS</option>
                    <option value="827">SANTO ANTÔNIO DE PÁDUA - POLICLÍNICA DR JUAREZ AMARAL DE AND</option>
                    <option value="I64">SÃO JOÃO DA BARRA - PROGRAMA MUNICIPAL IST/HIV/AIDS/HEPATITES VIRAIS</option>
                    <option value="055">SÃO JOÃO DE MERITI - PROGRAMA MUNICIPAL DST/AIDS DE SÃO JOÃO</option>
                    <option value="258">SÃO PEDRO D ALDEIA - SECRETARIA MUNICIPAL DE SÃO PEDRO D ALD</option>
                    <option value="828">SAPUCAIA - FARMÁCIA CENTRAL</option>
                    <option value="830">SAQUAREMA - PROGRAMA IST / AIDS</option>
                    <option value="061">SEAP</option>
                    <option value="976">SEROPÉDICA - SECRETARIA MUNICIPAL DE SAÚDE DE SEROPÉDICA</option>
                    <option value="H72">SMS CF ADERSON FERNANDES - AP 33</option>
                    <option value="532">SMS CF ADIB JATENE AP 31</option>
                    <option value="H73">SMS CF ADOLFO FERREIRA DE CARVALHO - AP 33</option>
                    <option value="H71">SMS CF ADV MARIO PIRES DA SILVA - AP 33</option>
                    <option value="F47">SMS CF AGENOR DE MIRANDA ARAUJO NETO - AP 52</option>
                    <option value="391">SMS CF ALICE DE JESUS REGO - AP 53</option>
                    <option value="F51">SMS CF ALKINDAR SOARES PEREIRA FILHO - AP 52</option>
                    <option value="344">SMS CF ALOYSIO AUGUSTO NOVIS - AP 31</option>
                    <option value="C98">SMS CF AMELIA DOS SANTOS FERREIRA - AP 32</option>
                    <option value="B54">SMS CF ANA GONZAGA - AP 52</option>
                    <option value="E92">SMS CF ANA MARIA CONCEICAO DOS SANTOS CORREIA - AP 33</option>
                    <option value="D72">SMS CF ANNA NERY - AP 32</option>
                    <option value="396">SMS CF ANTHIDIO DIAS DA SILVEIRA - AP 32</option>
                    <option value="I08">SMS CF ANTONIO GONCALVES DA SILVA - AP 51</option>
                    <option value="K07">SMS CF ANTONIO GONCALVES VILLA SOBRINHO - AP 52</option>
                    <option value="I10">SMS CF ARMANDO PALHARES AGUINAGA - AP 51</option>
                    <option value="J57">SMS CF ARTHUR BISPO DO ROSÁRIO - AP 40</option>
                    <option value="335">SMS CF ASSIS VALENTE - AP 31</option>
                    <option value="530">SMS CF AUGUSTO BOAL - AP 31</option>
                    <option value="D75">SMS CF BAIRRO CARIOCA - AP 32</option>
                    <option value="E52">SMS CF BARBARA MOSLEY DE SOUZA - AP 40</option>
                    <option value="C99">SMS CF BARBARA STARFIELD - AP 32</option>
                    <option value="D74">SMS CF BIBI VOGEL - AP 32</option>
                    <option value="D73">SMS CF CABO EDNEY CANAZARO DE OLIVEIRA - AP 32</option>
                    <option value="H70">SMS CF CANDIDO RIBEIRO DA SILVA FILHO - AP 33</option>
                    <option value="F24">SMS CF CANTAGALO PAVAO - PAVAOZINHO - AP 21</option>
                    <option value="F67">SMS CF CARLOS NERY DA COSTA FILHO - AP 33</option>
                    <option value="I02">SMS CF CRISTIANI VIEIRA PINHO - AP 51</option>
                    <option value="F68">SMS CF CYPRIANO DAS CHAGAS MEDEIROS - AP 33</option>
                    <option value="B53">SMS CF DALMIR DE ABREU SALGADO - AP 52</option>
                    <option value="E94">SMS CF DANTE ROMANO JUNIOR - AP 33</option>
                    <option value="J52">SMS CF DAVID CAPISTRANO FILHO - AP 52</option>
                    <option value="A35">SMS CF DEOLINDO COUTO - AP 53</option>
                    <option value="I94">SMS CF DEPUTADO PEDRO FERNANDES FILHO AP 33</option>
                    <option value="A39">SMS CF EDSON ABDALLA SAAD - AP 53</option>
                    <option value="L51">SMS CF EIDIMIR THIAGO DE SOUZA - AP 31</option>
                    <option value="D01">SMS CF EMYGDIO ALVES COSTA FILHO - AP 32</option>
                    <option value="H74">SMS CF ENFERMEIRA EDMA VALADAO - AP 33</option>
                    <option value="H75">SMS CF EPITACIO SOARES REIS - AP 33</option>
                    <option value="D70">SMS CF ERIVALDO FERNANDES NOBREGA - AP 32</option>
                    <option value="635">SMS CF ERNANI DE PAIVA FERREIRA BRAGA - AP 53</option>
                    <option value="J05">SMS CF EVERTON DE SOUZA SANTOS - AP 52</option>
                    <option value="453">SMS CF FAIM PEDRO - AP 51</option>
                    <option value="588">SMS CF FELIPPE CARDOSO - AP 31</option>
                    <option value="I01">SMS CF FIORELLO RAYMUNDO - AP 51</option>
                    <option value="E53">SMS CF GERSON BERGHER - AP 40</option>
                    <option value="L52">SMS CF HEITOR DOS PRAZERES - AP 31</option>
                    <option value="A40">SMS CF HELANDE DE MELLO GONCALVES - AP 53</option>
                    <option value="E54">SMS CF HELENA BESSERMAN VIANNA - AP 40</option>
                    <option value="D03">SMS CF HERBERT JOSE DE SOUZA - AP 32</option>
                    <option value="327">SMS CF ILZO MOTTA DE MELLO - AP 53</option>
                    <option value="J06">SMS CF ISABELA SEVERO DA SILVA - AP 52</option>
                    <option value="E91">SMS CF IVANIR DE MELLO - AP 33</option>
                    <option value="D71">SMS CF IZABEL DOS SANTOS - AP 32</option>
                    <option value="A42">SMS CF JAMIL HADDAD - AP 53</option>
                    <option value="L50">SMS CF JEREMIAS MORAES DA SILVA - AP 31</option>
                    <option value="A43">SMS CF JOAO BATISTA CHAGAS - AP 53</option>
                    <option value="941">SMS CF JOAOSINHO TRINTA - AP 31</option>
                    <option value="539">SMS CF JOSE ANTONIO CIRAUDO - AP 53</option>
                    <option value="J54">SMS CF JOSE DE PAULA LOPES PONTES - AP 52</option>
                    <option value="812">SMS CF JOSE DE SOUZA HERDY - AP 40</option>
                    <option value="H69">SMS CF JOSUETE SANTANNA DE OLIVEIRA - AP 33</option>
                    <option value="I07">SMS CF KELLY CRISTINA DE SA LACERDA SILVA - AP 51</option>
                    <option value="B63">SMS CF KLEBEL DE OLIVEIRA ROCHA - AP 31</option>
                    <option value="J04">SMS CF LECY RANQUINE - AP 52</option>
                    <option value="A45">SMS CF LENICE MARIA MONTEIRO COELHO - AP 53</option>
                    <option value="A46">SMS CF LOURENCO DE MELLO - AP 53</option>
                    <option value="E67">SMS CF LOURIVAL FRANCISCO DE OLIVEIRA - AP 40</option>
                    <option value="D79">SMS CF LUIZ CELIO PEREIRA - AP 32</option>
                    <option value="F42">SMS CF LUIZ DE MORAES JUNIOR (ROCHA MAIA) - AP 21</option>
                    <option value="B97">SMS CF MAICON SIQUEIRA - AP 40</option>
                    <option value="H76">SMS CF MANOEL FERNANDES DE ARAUJO - AP 33</option>
                    <option value="417">SMS CF MARCOS VALADAO - AP 33</option>
                    <option value="E43">SMS CF MARIA DO SOCORRO / ROCINHA - AP 21</option>
                    <option value="I11">SMS CF MARIA JOSE DE SOUSA BARBOSA - AP 51</option>
                    <option value="B51">SMS CF MARIA JOSE PAPERA DE AZEVEDO - AP 52</option>
                    <option value="341">SMS CF MARIA SEBASTIANA DE OLIVEIRA - AP 31</option>
                    <option value="F50">SMS CF MEDALHISTA OLIMPICO ARTHUR ZANETTI - AP 52</option>
                    <option value="F49">SMS CF MEDALHISTA OLIMPICO BRUNO SCHMIDT - AP 52</option>
                    <option value="K41">SMS CF MEDALHISTA OLIMPICO MAURICIO SILVA - AP 10</option>
                    <option value="E93">SMS CF MESTRE MOLEQUINHO DO IMPERIO - AP 33</option>
                    <option value="844">SMS CF NILDA CAMPOS DE LIMA - AP 31</option>
                    <option value="G65">SMS CF NILDO EYMAR DE ALMEIDA AGUIAR - AP 51</option>
                    <option value="B06">SMS CF ODALEA FIRMO DUTRA - AP 22</option>
                    <option value="D04">SMS CF OLGA PEREIRA PACHECO - AP 32</option>
                    <option value="I06">SMS CF OLIMPIA ESTEVES - AP 51</option>
                    <option value="473">SMS CF OTTO ALVES DE CARVALHO - AP 40</option>
                    <option value="478">SMS CF PADRE JOSE DE AZEVEDO TIUBA - AP 40</option>
                    <option value="J58">SMS CF PADRE MARCOS VINÍCIO MIRANDA VIEIRA - AP 40</option>
                    <option value="I93">SMS CF RAIMUNDO ALVES NASCIMENTO AP 33</option>
                    <option value="G69">SMS CF RECANTO DO TROVADOR - AP 22</option>
                    <option value="E45">SMS CF RINALDO DE LAMARE - AP 21</option>
                    <option value="071">SMS CF RODRIGO Y AGUILAR ROIG - AP 31</option>
                    <option value="K38">SMS CF ROGERIO PINTO DA MOTA - AP 51</option>
                    <option value="H99">SMS CF ROMULO CARLOS TEIXEIRA - AP 51</option>
                    <option value="A69">SMS CF SAMUEL PENHA VALLE - AP 53</option>
                    <option value="G67">SMS CF SANDRA REGINA SAMPAIO DE SOUZA - AP 51</option>
                    <option value="E47">SMS CF SANTA MARTA - AP 21</option>
                    <option value="J32">SMS CF SAO SEBASTIAO AP 10</option>
                    <option value="736">SMS CF SERGIO AROUCA - AP 53</option>
                    <option value="C97">SMS CF SERGIO NICOLAU AMIN - AP 32</option>
                    <option value="J33">SMS CF SERGIO VIEIRA DE MELLO AP 10</option>
                    <option value="K08">SMS CF SONIA MARIA FERREIRA MACHADO - AP 52</option>
                    <option value="026">SMS CF SOUZA MARQUES - AP 33</option>
                    <option value="F52">SMS CF VALDECIR SALUSTIANO CARDOZO - AP 52</option>
                    <option value="A68">SMS CF VALERIA GOMES ESTEVES - AP 53</option>
                    <option value="B66">SMS CF VALTER FELISBINO DE SOUZA - AP 31</option>
                    <option value="393">SMS CF VICTOR VALLA - AP 31</option>
                    <option value="349">SMS CF WALDEMAR BERARDINELLI - AP 53</option>
                    <option value="B64">SMS CF WILMA COSTA - AP 31</option>
                    <option value="273">SMS CF ZILDA ARNS - AP 31</option>
                    <option value="A48">SMS CMS ADELINO SIMOES - NOVA SEPETIBA - AP 53</option>
                    <option value="J85">SMS CMS ALBERTO BORGERTH - AP 33</option>
                    <option value="F69">SMS CMS ALICE TOLEDO TIBIRICA - AP 33</option>
                    <option value="A38">SMS CMS ALOYSIO AMANCIO DA SILVA - AP 53</option>
                    <option value="944">SMS CMS ALVIMAR DE CARVALHO - AP 52</option>
                    <option value="268">SMS CMS AMERICO VELOSO - AP 31</option>
                    <option value="D66">SMS CMS ARIADNE LOPES DE MENEZES - AP 32</option>
                    <option value="I09">SMS CMS ATHAYDE JOSE DA FONSECA - AP 51</option>
                    <option value="F70">SMS CMS AUGUSTO DO AMARAL PEIXOTO - AP 33</option>
                    <option value="339">SMS CMS BELIZARIO PENNA - AP 52</option>
                    <option value="G63">SMS CMS BUA BOANERGES BORGES DA FONSECA - AP 51</option>
                    <option value="G70">SMS CMS CARLOS FIGUEIREDO FILHO / BOREL - AP 22</option>
                    <option value="D02">SMS CMS CARLOS GENTILLE DE MELLO - AP 32</option>
                    <option value="269">SMS CMS CARMELA DUTRA - AP 33</option>
                    <option value="G66">SMS CMS CASA BRANCA - AP 22</option>
                    <option value="A33">SMS CMS CATTAPRETA - AP 53</option>
                    <option value="E57">SMS CMS CECILIA DONNANGELO - AP 40</option>
                    <option value="D68">SMS CMS CESAR PERNETTA - AP 32</option>
                    <option value="A34">SMS CMS CESARIO DE MELLO - AP 53</option>
                    <option value="F23">SMS CMS CHAPEU MANG BABILONIA - AP 21</option>
                    <option value="033">SMS CMS CLEMENTINO FRAGA - AP 33</option>
                    <option value="A37">SMS CMS CYRO DE MELLO MANGUARIBA - AP 53</option>
                    <option value="A36">SMS CMS DECIO AMARAL FILHO - AP 53</option>
                    <option value="945">SMS CMS DOM HELDER CAMARA - AP 21</option>
                    <option value="E44">SMS CMS DR ALBERT SABIN - AP 21</option>
                    <option value="J53">SMS CMS DR MARIO RODRIGUES CID - AP 52</option>
                    <option value="B52">SMS CMS EDGARD MAGALHAES GOMES - AP 52</option>
                    <option value="D65">SMS CMS EDUARDO ARAUJO VILHENA LEITE - AP 32</option>
                    <option value="I81">SMS CMS ELIZA ABRANTES (AQUIDABÃ) - AP 32</option>
                    <option value="639">SMS CMS EMYDIO CABRAL - AP 53</option>
                    <option value="342">SMS CMS ERNANI AGRICOLA - AP 10</option>
                    <option value="266">SMS CMS ERNESTO ZEFERINO TIBAU JR - AP 10</option>
                    <option value="F71">SMS CMS FLAVIO DO COUTO VIEIRA - AP 33</option>
                    <option value="A41">SMS CMS FLORIPES GALDINO PEREIRA - AP 53</option>
                    <option value="F53">SMS CMS GARFIELD DE ALMEIDA - AP 52</option>
                    <option value="E62">SMS CMS HAMILTON LAND - AP 40</option>
                    <option value="946">SMS CMS HARVEY RIBEIRO DE SOUZA FILHO - AP 40</option>
                    <option value="027">SMS CMS HEITOR BELTRAO - AP 22</option>
                    <option value="H97">SMS CMS HENRIQUE MONAT - AP 51</option>
                    <option value="024">SMS CMS JOAO BARROS BARRETO - AP 21</option>
                    <option value="E59">SMS CMS JORGE SALDANHA BANDEIRA DE MELLO - AP 40</option>
                    <option value="267">SMS CMS JOSE MESSIAS DO CARMO - AP 10</option>
                    <option value="270">SMS CMS MADRE TERESA DE CALCUTA - AP 31</option>
                    <option value="J30">SMS CMS MANOEL ARTHUR VILLABOIM - PAQUETÁ AP 10 </option>
                    <option value="023">SMS CMS MANOEL JOSE FERREIRA - AP 21</option>
                    <option value="022">SMS CMS MARCOLINO CANDAU AP 10</option>
                    <option value="E50">SMS CMS MARIA APARECIDA DE ALMEIDA - AP 53</option>
                    <option value="028">SMS CMS MARIA AUGUSTA ESTRELLA - AP 22</option>
                    <option value="J25">SMS CMS MARIO OLINTO OLIVEIRA AP 33</option>
                    <option value="H98">SMS CMS MASAO GOTO - AP 51</option>
                    <option value="032">SMS CMS MILTON FONTES MAGARAO - AP 32</option>
                    <option value="B56">SMS CMS MOURAO FILHO - AP 52</option>
                    <option value="528">SMS CMS NAGIB JORGE FARAH - AP 31</option>
                    <option value="E95">SMS CMS NASCIMENTO GURGEL - AP 33</option>
                    <option value="A63">SMS CMS NECKER PINTO - AP 31</option>
                    <option value="G68">SMS CMS NICOLA ALBANO - AP 22</option>
                    <option value="G64">SMS CMS NILZA ROSA - AP 22</option>
                    <option value="521">SMS CMS OSWALDO CRUZ - AP 10</option>
                    <option value="K39">SMS CMS PADRE MIGUEL - AP 51</option>
                    <option value="L46">SMS CMS PARQUE ROYAL - AP 31</option>
                    <option value="025">SMS CMS PINDARO DE CARVALHO RODRIGUES - AP 21</option>
                    <option value="D67">SMS CMS RENATO ROCCO - AP 32</option>
                    <option value="E46">SMS CMS RODOLPHO PERISSE / VIDIGAL - AP 21</option>
                    <option value="J31">SMS CMS SALLES NETTO AP 10</option>
                    <option value="J59">SMS CMS SANTA MARIA - AP 40</option>
                    <option value="405">SMS CMS SAVIO ANTUNES / ANTARES - AP 53</option>
                    <option value="H77">SMS CMS SYLVIO FREDERICO BRAUNER - AP 33</option>
                    <option value="D69">SMS CMS TIA ALICE - AP 32</option>
                    <option value="F22">SMS CMS VILA CANOAS - AP 21</option>
                    <option value="F54">SMS CMS VILA DO CEU - AP 52</option>
                    <option value="045">SMS CMS WALDYR FRANCO - AP 51</option>
                    <option value="K40">SMS CSE LAPA - AP 10</option>
                    <option value="048">SMS POLICLINICA ANTONIO RIBEIRO NETTO - AP 10</option>
                    <option value="274">SMS POLICLINICA CARLOS ALBERTO NASCIMENTO - AP 52</option>
                    <option value="054">SMS POLICLINICA HELIO PELLEGRINO - AP 22</option>
                    <option value="030">SMS POLICLINICA JOSE PARANHOS FONTENELLE - AP 31</option>
                    <option value="050">SMS POLICLINICA LINCOLN DE FREITAS FILHO - AP 53</option>
                    <option value="929">SMS POLICLINICA NEWTON ALVES CARDOZO - AP 31</option>
                    <option value="029">SMS POLICLINICA NEWTON BETHLEM - AP 40</option>
                    <option value="031">SMS POLICLINICA RODOLPHO ROCCO - AP 32</option>
                    <option value="D55">TANGUA - PROGRAMA DE IST, AIDS E HEPATITES VIRAIS</option>
                    <option value="579">TERESÓPOLIS - SECRETARIA MUNICIPAL DE SAÚDE DE TERESÓPOLIS</option>
                    <option value="831">TRÊS RIOS - VIGILÂNCIA EPIDEMIOLÓGICA</option>
                    <option value="169">VALENÇA - CASA DA SAÚDE COLETIVA DE VALENÇA</option>
                    <option value="168">VASSOURAS - POLICLINICA DE VASSOURAS</option>
                    <option value="167">VOLTA REDONDA - CENTRO DE DOENCAS INFECCIOSAS DR. LUIZ GONZAGA</option>
                </select>

                <br>

                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF"
                    style="width: 620px;"><br><br>

                <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha"
                    style="width: 620px;"><br><br>

                <input onclick="window.location.href = 'principal.php';" type="submit" name="entrar" value="ENTRAR"
                    style="width: 620px; background-color: #e43d3d; color: rgb(255, 255, 255); border: 0px; border-radius: 5px; height: 40px; font-weight: 700;"
                    ><br>

                <p><a style="text-decoration: none; color:rgb(129, 129, 129); font-weight: 650;" href="forgotpassw.php"
                        class="link">Redefinir senha</a></p>
            </div>
        </form>
    </div>
</body>

</html>
<?php

?>