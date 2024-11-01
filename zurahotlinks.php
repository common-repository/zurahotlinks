<?php
/*
Plugin Name: Zura HotLinks
Plugin URI: http://www.zura.com.br/
Description: Plugin para criação de hotlinks para o Zura
Author: plugins_zura
Version: 1.1
Author URI: http://www.zura.com.br/
*/

/**
 * Zura Hot Links
 * 
 * @author Zura <wp-plugins@zura.com.br>
 *
 */
 
class zuraHotLinks {

	private static $wpdb;
	private static $info;
	private static $blog_id;
	private static $words;
	
	/**
	 * Função de inicialização, centraliza a definição de filtros/ações
	 *
	 */
	public static function inicializar($instalacao = false) {
    
		global $wpdb;
        
        global $blog_id;
		
		//Mapear objetos WP
		zuraHotLinks::$wpdb = $wpdb;
		
		//Mapear objetos WP
		zuraHotLinks::$blog_id = $blog_id;
		
		//Outros mapeamentos
		zuraHotLinks::$info['plugin_fpath'] = dirname(__FILE__); 
        
        
        if(function_exists("get_blog_option")) {
            $string = get_blog_option(zuraHotLinks::$blog_id,"zhl_words");
            $words = zuraHotLinks::stringToArray($string);
            $string = get_blog_option(zuraHotLinks::$blog_id,"zhl_settings");
            $settings = zuraHotLinks::stringToArray($string);
        } else {
            $string = get_option("zhl_words");
            $words = zuraHotLinks::stringToArray($string);
            $string = get_option("zhl_settings");
            $settings = zuraHotLinks::stringToArray($string);
        }
        
        $atualiza_settings = false;
        $atualiza_words = false;
        
        if(count($settings)==0) {
        
            $settings = array (
                "pr"		=> 0,
                "site"		=> '',
                "blank"		=> false,
                "charset"   => 'UTF-8',
                "links"   => 5,
            );
            
            $atualiza_settings = true;
            
        }
        
        if(count($words)==0) {
        

            $words["Notebook HP"] = 'http://www.zura.com.br/notebook--hp.html';
            $words["Notebook Acer"] = 'http://www.zura.com.br/notebook--acer.html';
            $words["Notebook Positivo"] = 'http://www.zura.com.br/notebook--positivo.html';
            $words["Notebook"] = 'http://www.zura.com.br/notebook.html';
            $words["Laptop"] = 'http://www.zura.com.br/notebook.html';
            $words["Tv Lcd"] = 'http://www.zura.com.br/tv--de-lcd.html';
            $words["Tv Lcd 32"] = 'http://www.zura.com.br/tv--de-lcd--30-a-39-polegadas.html';
            $words["Tv Lcd 42"] = 'http://www.zura.com.br/tv--de-lcd--40-a-49-polegadas.html';
            $words["Fog&atilde;o"] = 'http://www.zura.com.br/fogoes.html';
            $words["Fog&atilde;o Brastemp"] = 'http://www.zura.com.br/fogoes--brastemp.html';
            $words["Fog&atilde;o Cooktop"] = 'http://www.zura.com.br/fogoes--cooktop.html';
            $words["Fog&otilde;es Brastemp"] = 'http://www.zura.com.br/fogoes--brastemp.html';
            $words["Fog&otilde;es Fischer"] = 'http://www.zura.com.br/fogoes--fischer.html';
            $words["Fog&otilde;es "] = 'http://www.zura.com.br/fogoes.html';
            $words["Televisor 32"] = 'http://www.zura.com.br/tv--30-a-39-polegadas.html';
            $words["Televisor 42"] = 'http://www.zura.com.br/tv--40-a-49-polegadas.html';
            $words["Televisor"] = 'http://www.zura.com.br/tv.html';
            $words["Adega De Vinho"] = 'http://www.zura.com.br/adega-de-vinho.html';
            $words["Ar Condicionado"] = 'http://www.zura.com.br/ar-condicionado.html';
            $words["Aspirador De P&oacute;"] = 'http://www.zura.com.br/aspirador-de-po.html';
            $words["Batedeira"] = 'http://www.zura.com.br/batedeira.html';
            $words["Bebedouro"] = 'http://www.zura.com.br/bebedouro.html';
            $words["Cafeteira"] = 'http://www.zura.com.br/cafeteira.html';
            $words["Centr&iacute;fuga De Alimentos"] = 'http://www.zura.com.br/centrifuga-de-alimentos.html';
            $words["Chapas"] = 'http://www.zura.com.br/chapas.html';
            $words["Chopeira"] = 'http://www.zura.com.br/chopeira.html';
            $words["Chuveiro"] = 'http://www.zura.com.br/chuveiro-ducha.html';
            $words["Ducha"] = 'http://www.zura.com.br/chuveiro-ducha.html';
            $words["Circulador"] = 'http://www.zura.com.br/circulador-ventilador.html';
            $words["Ventilador"] = 'http://www.zura.com.br/circulador-ventilador.html';
            $words["Jarra El&eacute;trica"] = 'http://www.zura.com.br/jarra-eletrica.html';
            $words["Lava A Jato"] = 'http://www.zura.com.br/lava-a-jato.html';
            $words["Lava Lou&ccedil;as"] = 'http://www.zura.com.br/lava-loucas.html';
            $words["Climatizador"] = 'http://www.zura.com.br/climatizador.html';
            $words["Depurador De Ar"] = 'http://www.zura.com.br/depurador-de-ar-coifa.html';
            $words["Coifa"] = 'http://www.zura.com.br/depurador-de-ar-coifa.html';
            $words["Fritadeira"] = 'http://www.zura.com.br/fritadeira.html';
            $words["Frigobar"] = 'http://www.zura.com.br/frigobar.html';
            $words["M&aacute;quina De Gelo"] = 'http://www.zura.com.br/maquina-de-gelo.html';
            $words["M&aacute;quina De P&atilde;o"] = 'http://www.zura.com.br/maquina-de-pao.html';
            $words["M&aacute;quina De Sorvete"] = 'http://www.zura.com.br/maquina-de-sorvete.html';
            $words["Mixer"] = 'http://www.zura.com.br/mixer.html';
            $words["Panela El&eacute;trica"] = 'http://www.zura.com.br/panela-eletrica.html';
            $words["Pipoqueira"] = 'http://www.zura.com.br/pipoqueira.html';
            $words["Sanduicheira"] = 'http://www.zura.com.br/sanduicheira-grill.html';
            $words["Grill"] = 'http://www.zura.com.br/sanduicheira-grill.html';
            $words["Secadora"] = 'http://www.zura.com.br/secadora-de-roupa-centrifuga.html';
            $words["Centrifuga"] = 'http://www.zura.com.br/secadora-de-roupa-centrifuga.html';
            $words["Tanquinho"] = 'http://www.zura.com.br/tanquinho.html';
            $words["Torradeira"] = 'http://www.zura.com.br/torradeira.html';
            $words["Umidificador"] = 'http://www.zura.com.br/umidificador.html';
            $words["Vaporizador"] = 'http://www.zura.com.br/vaporizador.html';
            $words["Vassoura El&eacute;trica"] = 'http://www.zura.com.br/vassoura-eletrica.html';
            $words["Waffles"] = 'http://www.zura.com.br/waffles.html';
            $words["Espremedor De Frutas"] = 'http://www.zura.com.br/espremedor-de-frutas.html';
            $words["Esterilizador"] = 'http://www.zura.com.br/esterilizador-purificador-de-ar.html';
            $words["Purificador De Ar"] = 'http://www.zura.com.br/esterilizador-purificador-de-ar.html';
            $words["Faca El&eacute;trica"] = 'http://www.zura.com.br/faca-eletrica.html';
            $words["Fatiador De Frios"] = 'http://www.zura.com.br/fatiador-de-frios.html';
            $words["Ferro De Passar"] = 'http://www.zura.com.br/ferro-de-passar.html';
            $words["Fonte De Chocolate"] = 'http://www.zura.com.br/fonte-de-chocolate.html';
            $words["Forno Industrial"] = 'http://www.zura.com.br/forno-industrial.html';
            $words["Fornos"] = 'http://www.zura.com.br/fornos.html';
            $words["Freezer"] = 'http://www.zura.com.br/freezer.html';
            $words["Refrigerador Frost Free"] = 'http://www.zura.com.br/geladeira--frost-free.html';
            $words["Refrigerador Brastemp"] = 'http://www.zura.com.br/geladeira--brastemp.html';
            $words["Refrigerador Consul"] = 'http://www.zura.com.br/geladeira--consul.html';
            $words["Refrigerador"] = 'http://www.zura.com.br/geladeira.html';
            $words["Frost Free"] = 'http://www.zura.com.br/geladeira--frost-free.html';
            $words["Geladeira Frost Free"] = 'http://www.zura.com.br/geladeira--frost-free.html';
            $words["Geladeira Brastemp"] = 'http://www.zura.com.br/geladeira--brastemp.html';
            $words["Geladeira Consul"] = 'http://www.zura.com.br/geladeira--consul.html';
            $words["Geladeira"] = 'http://www.zura.com.br/geladeira.html';
            $words["Micro-ondas"] = 'http://www.zura.com.br/micro-ondas.html';
            $words["Microondas Brastemp"] = 'http://www.zura.com.br/micro-ondas--brastemp.html';
            $words["Microondas Consul"] = 'http://www.zura.com.br/micro-ondas--consul.html';
            $words["Microondas"] = 'http://www.zura.com.br/micro-ondas.html';
            $words["Notebook Infantil"] = 'http://www.zura.com.br/notebook-infantil.html';
            $words["Patinetes"] = 'http://www.zura.com.br/patinetes.html';
            $words["Pel&uacute;cia"] = 'http://www.zura.com.br/pelucia.html';
            $words["Bonecas"] = 'http://www.zura.com.br/bonecas.html';
            $words["Cal&ccedil;ado Infantil"] = 'http://www.zura.com.br/calcado-infantil.html';
            $words["Cal&ccedil;ado Feminino"] = 'http://www.zura.com.br/calcado-feminino.html';
            $words["Chinelos"] = 'http://www.zura.com.br/chinelos.html';
            $words["T&ecirc;nis"] = 'http://www.zura.com.br/tenis.html';
            $words["Tamanco"] = 'http://www.zura.com.br/calcado-feminino.html?key=Tamanco';
            $words["C&acirc;mera Digital"] = 'http://www.zura.com.br/camera-digital.html';
            $words["DVD Player"] = 'http://www.zura.com.br/dvd-player.html';
            $words["Cart&otilde;es De Mem&oacute;ria"] = 'http://www.zura.com.br/cartoes-de-memoria.html';
            $words["TV"] = 'http://www.zura.com.br/tv.html';
            $words["Webcam"] = 'http://www.zura.com.br/webcam.html';
            $words["Telas De Proje&ccedil;&atilde;o"] = 'http://www.zura.com.br/telas-de-projecao.html';
            $words["Monitor"] = 'http://www.zura.com.br/monitor.html';
            $words["Impressora"] = 'http://www.zura.com.br/impressora-multifuncional.html';
            $words["Mem&oacute;ria Ram"] = 'http://www.zura.com.br/memoria-ram.html';
            $words["Mem&oacute;ria"] = 'http://www.zura.com.br/memoria-ram.html';
            $words["Processador"] = 'http://www.zura.com.br/processador.html';
            $words["Wireless"] = 'http://www.zura.com.br/roteador.html';
            $words["Toner"] = 'http://www.zura.com.br/toner.html';
            $words["No Break"] = 'http://www.zura.com.br/no-break.html';
            $words["Pen Drive"] = 'http://www.zura.com.br/pen-drive.html';
            $words["Mouse"] = 'http://www.zura.com.br/mouses.html';
            $words["Scanner"] = 'http://www.zura.com.br/scanner.html';
            $words["Celular"] = 'http://www.zura.com.br/celular.html';
            $words["Smartphone"] = 'http://www.zura.com.br/smartphone.html';
            $words["Walk Talk"] = 'http://www.zura.com.br/walk-talk-radios-comunicadores.html';
            $words["PABX"] = 'http://www.zura.com.br/centrais-telefonicas-pabx.html';
            $words["FAX"] = 'http://www.zura.com.br/fax.html';
            $words["Console"] = 'http://www.zura.com.br/console.html';
            $words["Xbox"] = 'http://www.zura.com.br/jogos-xbox-360.html';
            $words["PS2"] = 'http://www.zura.com.br/console--playstation-2.html';
            $words["PS3"] = 'http://www.zura.com.br/console--playstation-3.html';
            $words["Som Automotivo"] = 'http://www.zura.com.br/som-automotivo.html';
            $words["Mp5 Player"] = 'http://www.zura.com.br/mp5-player.html';
            $words["Fone De Ouvido"] = 'http://www.zura.com.br/fone-de-ouvido.html';
            $words["GPS"] = 'http://www.zura.com.br/gps.html';
            $words["Mini System"] = 'http://www.zura.com.br/micro-mini-system.html';
            $words["Home Theater"] = 'http://www.zura.com.br/home-theater.html';
            $words["Carros Usado"] = 'http://www.zura.com.br/automovel-usado.html';
            $words["Carros Novos"] = 'http://www.zura.com.br/automovel-novo.html';
            $words["Carros"] = 'http://www.zura.com.br/automovel-usado.html';
            $words["Carro"] = 'http://www.zura.com.br/carros-motos.html';
            $words["Pneu"] = 'http://www.zura.com.br/pneus.html';
            $words["Mochila"] = 'http://www.zura.com.br/mochila-esportiva.html';
            $words["Mala"] = 'http://www.zura.com.br/bolsas-malas.html';
            $words["Bolsa"] = 'http://www.zura.com.br/bolsas-malas.html';
            $words["Barbeador Eletronico"] = 'http://www.zura.com.br/barbeador-eletrico.html';
            $words["Bicicleta"] = 'http://www.zura.com.br/bicicleta.html';
            $words["Muscula&ccedil;&atilde;o"] = 'http://www.zura.com.br/ginastica-musculacao.html';
            $words["Perfumes"] = 'http://www.zura.com.br/perfume.html';
            $words["Perfume"] = 'http://www.zura.com.br/perfume.html';
            $words["Rel&oacute;gio"] = 'http://www.zura.com.br/relogio-de-pulso.html';
            $words["Andador"] = 'http://www.zura.com.br/andador.html';
            $words["Carrinho De Beb&ecirc;"] = 'http://www.zura.com.br/carrinho.html';
            $words["Ber&ccedil;o"] = 'http://www.zura.com.br/bercos-cercados.html';
            $words["Cercado"] = 'http://www.zura.com.br/bercos-cercados.html';
            $words["Mochila Escolar"] = 'http://www.zura.com.br/mochilas-bolsas-escolares.html';
            $words["Monitor LCD "] = 'http://www.zura.com.br/monitor--de-lcd.html';
            $words["Monitor Cardi&aacute;co"] = 'http://www.zura.com.br/monitor-cardiaco.html';
            $words["Livros"] = 'http://www.zura.com.br/livros.html';
            $words["Computador"] = 'http://www.zura.com.br/computador.html';
            $words["Teclado"] = 'http://www.zura.com.br/teclados.html';
            $words["Compare"] = 'http://www.zura.com.br/';
            $words["Compre"] = 'http://www.zura.com.br/';
            $words["Comprar"] = 'http://www.zura.com.br/';
            $words["Melhor Pre&ccedil;o"] = 'http://www.zura.com.br/';
            $words["Lojas"] = 'http://www.zura.com.br/';
            $words["Comparar Pre&ccedil;os"] = 'http://www.zura.com.br/';
            $words["Pesquisa De Pre&ccedil;os"] = 'http://www.zura.com.br/';
            $words["Preco Venda"] = 'http://www.zura.com.br/';
            $words["Comprar Pre&ccedil;os"] = 'http://www.zura.com.br/';
            $words["Pre&ccedil;os"] = 'http://www.zura.com.br/';
            $words["Windows"] = 'http://www.zura.com.br/';
            $words["Busca"] = 'http://www.zura.com.br/';
            $words["Busca Pre&ccedil;o"] = 'http://www.zura.com.br/';
            $words["Compra"] = 'http://www.zura.com.br/';
            $words["Pre&ccedil;o Baixo"] = 'http://www.zura.com.br/';
            $words["Lista De Presente"] = 'http://www.zura.com.br/';
            $words["Busca Produto"] = 'http://www.zura.com.br/';
            $words["Procura"] = 'http://www.zura.com.br/';
            $words["Lojas Online"] = 'http://www.zura.com.br/';
            $words["Produto"] = 'http://www.zura.com.br/';
            $words["Oferta"] = 'http://www.zura.com.br/';
            $words["Varejo"] = 'http://www.zura.com.br/';
            $words["Venda "] = 'http://www.zura.com.br/';
            $words["Pre&ccedil;o"] = 'http://www.zura.com.br/';
            $words["Iphones"] = 'http://www.zura.com.br/celular.html?key=iphone';
            $words["Iphone"] = 'http://www.zura.com.br/celular.html?key=iphone';
            $words["iPhone"] = 'http://www.zura.com.br/celular.html?key=iphone';
            $words["Ipod"] = 'http://www.zura.com.br/mp3-player.html?key=ipod';
            $words["Placa De Video"] = 'http://www.zura.com.br/placas-de-video.html';
            $words["Headset"] = 'http://www.zura.com.br/fone-de-ouvido.html';
            $words["Microfone"] = 'http://www.zura.com.br/microfone.html';
            $words["Comprado"] = 'http://www.zura.com.br/';
            $words["Loja"] = 'http://www.zura.com.br/';
            $words["Camisas"] = 'http://www.zura.com.br/vestuario-esportivo.html?key=camisas';
            $words["Vestidos"] = 'http://www.zura.com.br/roupa-feminina.html?key=vestido';
            $words["Sapatos"] = 'http://www.zura.com.br/calcado-feminino.html?key=sapatos';
            $words["Modem"] = 'http://www.zura.com.br/modem.html';
            $words["Roteador"] = 'http://www.zura.com.br/roteador.html';
            $words["Sistema Operacional"] = 'http://www.zura.com.br/sistema-operacional.html';
            $words["Controle Remoto"] = 'http://www.zura.com.br/controle-remoto.html';
            $words["Computadores"] = 'http://www.zura.com.br/computador.html';
            $words["Hiphone"] = 'http://www.zura.com.br/celular--hiphone.html';
            $words["Celular Lg"] = 'http://www.zura.com.br/celular--lg.html';
            $words["Celular Motorola"] = 'http://www.zura.com.br/celular--motorola.html';
            $words["Celular Nokia"] = 'http://www.zura.com.br/celular--nokia.html';
            $words["Celular Samsung"] = 'http://www.zura.com.br/celular--samsung.html';
            $words["Celular Sony Ericsson"] = 'http://www.zura.com.br/celular--sony-ericsson.html';
            $words["Desktop"] = 'http://www.zura.com.br/computador.html';
            $words["Chinelos"] = 'http://www.zura.com.br/chinelos.html';
            $words["Raquetes"] = 'http://www.zura.com.br/mais-buscados/raquetes.html';
            $words["Antiv&iacute;rus"] = 'http://www.zura.com.br/anti-virus-seguranca.html';
            $words["Acessorios"] = 'http://www.zura.com.br/mais-buscados/acessorios.html';
            $words["Wi-FI"] = 'http://www.zura.com.br/mais-buscados/Wi-Fi.html';
            $words["Jogos"] = 'http://www.zura.com.br/mais-buscados/Jogos.html';
            $words["Jogo"] = 'http://www.zura.com.br/mais-buscados/Jogos.html';
            $words["Temporada"] = 'http://www.zura.com.br/mais-buscados/temporada.html';
            $words["Sapatilhas"] = 'http://www.zura.com.br/mais-buscados/sapatilhas.html';
            $words["Botas"] = 'http://www.zura.com.br/mais-buscados/botas.html';
            $words["Cal&ccedil;ados"] = 'http://www.zura.com.br/mais-buscados/calcados.html';
            $words["Sand&aacute;lias"] = 'http://www.zura.com.br/mais-buscados/sandalias.html';
            $words["Portatil"] = 'http://www.zura.com.br/mais-buscados/portatil.html';
            $words["Slim"] = 'http://www.zura.com.br/mais-buscados/slim.html';
            $words["Full HD"] = 'http://www.zura.com.br/mais-buscados/full_hd.html';
            $words["HDTV"] = 'http://www.zura.com.br/mais-buscados/hdtv.html';
            $words["HDMI"] = 'http://www.zura.com.br/mais-buscados/hdmi.html';
            $words["LCD"] = 'http://www.zura.com.br/mais-buscados/lcd.html';
            $words["Digital"] = 'http://www.zura.com.br/mais-buscados/digital.html';
            $words["Cyber Shot"] = 'http://www.zura.com.br/mais-buscados/cyber_shot.html';
            $words["MegaPixel"] = 'http://www.zura.com.br/mais-buscados/megapixels.html';
            $words["Megapixels"] = 'http://www.zura.com.br/mais-buscados/megapixels.html';
            $words["USB"] = 'http://www.zura.com.br/mais-buscados/usb.html';
            $words["Optico"] = 'http://www.zura.com.br/mais-buscados/optico.html';
            $words["Wireless"] = 'http://www.zura.com.br/mais-buscados/wireless.html';
            $words["Adaptador"] = 'http://www.zura.com.br/mais-buscados/adaptador.html';
            $words["Sata"] = 'http://www.zura.com.br/mais-buscados/sata.html';
            $words["Esporte"] = 'http://www.zura.com.br/mais-buscados/esporte.html';
            $words["Sleep Timer"] = 'http://www.zura.com.br/mais-buscados/sleep_timer.html';
            $words["Audio"] = 'http://www.zura.com.br/mais-buscados/audio.html';
            $words["Ultra Slim"] = 'http://www.zura.com.br/mais-buscados/ultra_slim.html';
            $words["Time Machine"] = 'http://www.zura.com.br/mais-buscados/time_machine.html';
            $words["Polegadas"] = 'http://www.zura.com.br/mais-buscados/polegadas.html';
            $words["Widescreen"] = 'http://www.zura.com.br/mais-buscados/widescreen.html';
            $words["Linux"] = 'http://www.zura.com.br/mais-buscados/linux.html';
            $words["DVD RW"] = 'http://www.zura.com.br/mais-buscados/dvd_rw.html';
            $words["Aspire"] = 'http://www.zura.com.br/mais-buscados/aspire.html';
            $words["Embutir"] = 'http://www.zura.com.br/mais-buscados/embutir.html';
            $words["Timer"] = 'http://www.zura.com.br/mais-buscados/timer.html';
            $words["Subwoofer"] = 'http://www.zura.com.br/mais-buscados/subwoofer.html';
            $words["System"] = 'http://www.zura.com.br/mais-buscados/system.html';
            $words["Caixas"] = 'http://www.zura.com.br/mais-buscados/caixas.html';
            $words["Moda"] = 'http://www.zura.com.br/mais-buscados/moda.html';
            $words["Core I3"] = 'http://www.zura.com.br/mais-buscados/Core_i3.html';
            $words["Core I7"] = 'http://www.zura.com.br/mais-buscados/Core_i7.html';
            $words["Nokia"] = 'http://www.zura.com.br/mais-buscados/nokia.html';
            $words["Eeepc"] = 'http://www.zura.com.br/mais-buscados/eeepc.html';
            $words["TFT"] = 'http://www.zura.com.br/mais-buscados/tft.html';
            $words["Sintonizador"] = 'http://www.zura.com.br/mais-buscados/sintonizador.html';
            $words["Sound"] = 'http://www.zura.com.br/mais-buscados/sound.html';
            $words["Notebook Dicas"] = 'http://www.zura.com.br/mais-buscados/notebook_dicas.html';
            $words["Upgrade"] = 'http://www.zura.com.br/mais-buscados/upgrade.html';
            $words["Vaio"] = 'http://www.zura.com.br/mais-buscados/vaio.html';
            $words["Ethernet"] = 'http://www.zura.com.br/mais-buscados/ethernet.html';
            $words["Bluetooth"] = 'http://www.zura.com.br/mais-buscados/bluetooth.html';
            $words["Windows"] = 'http://www.zura.com.br/mais-buscados/windows.html';
            $words["Bivolt"] = 'http://www.zura.com.br/mais-buscados/bivolt.html';
            $words["Mhz"] = 'http://www.zura.com.br/mais-buscados/mhz.html';
            $words["Scarlet"] = 'http://www.zura.com.br/mais-buscados/scarlet.html';
            $words["Bravia"] = 'http://www.zura.com.br/mais-buscados/bravia.html';
            $words["Wi-fi"] = 'http://www.zura.com.br/mais-buscados/Wi_Fi.html';
            $words["Constrate"] = 'http://www.zura.com.br/mais-buscados/contraste.html';
            $words["Resolu&ccedil;&atilde;o"] = 'http://www.zura.com.br/mais-buscados/resolucao.html';
            $words["Super Video"] = 'http://www.zura.com.br/mais-buscados/super_video.html';
            $words["Hdd"] = 'http://www.zura.com.br/mais-buscados/hdd.html';
            $words["TV Wide"] = 'http://www.zura.com.br/mais-buscados/tv_wide.html';
            $words["Wide "] = 'http://www.zura.com.br/mais-buscados/wide.html';
            $words["DVI"] = 'http://www.zura.com.br/mais-buscados/DVI.html';
            $words["Seguran&ccedil;a"] = 'http://www.zura.com.br/mais-buscados/seguranca.html';
            $words["Aparelho"] = 'http://www.zura.com.br/mais-buscados/aparelho.html';
            $words["GSM"] = 'http://www.zura.com.br/mais-buscados/gsm.html';
            $words["CDMA"] = 'http://www.zura.com.br/mais-buscados/cdma.html';
            $words["Cookie"] = 'http://www.zura.com.br/mais-buscados/cookie.html';
            $words["Jet"] = 'http://www.zura.com.br/mais-buscados/jet.html';
            $words["Turbo"] = 'http://www.zura.com.br/mais-buscados/turbo.html';
            $words["Masculino"] = 'http://www.zura.com.br/mais-buscados/masculino.html';
            $words["Feminino"] = 'http://www.zura.com.br/mais-buscados/feminino.html';
            $words["Infantil"] = 'http://www.zura.com.br/mais-buscados/infantil.html';
            $words["Silicone"] = 'http://www.zura.com.br/mais-buscados/silicone.html';
            $words["Kit"] = 'http://www.zura.com.br/mais-buscados/kit.html';
            $words["Inox"] = 'http://www.zura.com.br/mais-buscados/inox.html';
            $words["Gourmet"] = 'http://www.zura.com.br/mais-buscados/gourmet.html';
            $words["Neon"] = 'http://www.zura.com.br/mais-buscados/neon.html';
            $words["Blusas"] = 'http://www.zura.com.br/mais-buscados/blusas.html';
            $words["Chips"] = 'http://www.zura.com.br/mais-buscados/chips.html';
            $words["Velocidades"] = 'http://www.zura.com.br/mais-buscados/velocidades.html';
            $words["CPU"] = 'http://www.zura.com.br/mais-buscados/CPU.html';
            $words["Alimenta&ccedil;&atilde;o"] = 'http://www.zura.com.br/mais-buscados/Alimentacao.html';
            $words["Instrumentos "] = 'http://www.zura.com.br/mais-buscados/Instrumentos.html';
            $words["Academias, Aparelhos E Equipamentos"] = 'http://www.zura.com.br/academias-aparelhos-equipamentos.html';
            $words["Equipamento Ginastica"] = 'http://www.zura.com.br/academias-aparelhos-equipamentos.html';
            $words["A&ccedil;&atilde;o - Aluguel"] = 'http://www.zura.com.br/acao-aluguel.html';
            $words["Acess&oacute;rios / Suprimentos Para Impress&atilde;o"] = 'http://www.zura.com.br/acessorios-suprimentos-para-impressao.html';
            $words["Acess&oacute;rios Automotivos"] = 'http://www.zura.com.br/acessorios-automotivos.html';
            $words["Acess&oacute;rios De Maquiagem"] = 'http://www.zura.com.br/acessorios-de-maquiagem.html';
            $words["Acess&oacute;rios De Moda"] = 'http://www.zura.com.br/acessorios-de-moda.html';
            $words["Acess&oacute;rios Eletr&ocirc;nicos"] = 'http://www.zura.com.br/acessorios-eletronicos.html';
            $words["Acess&oacute;rios Er&oacute;ticos"] = 'http://www.zura.com.br/acessorios-eroticos.html';
            $words["Acess&oacute;rios IP"] = 'http://www.zura.com.br/acessorios-ip.html';
            $words["Acess&oacute;rios Para Acabamento"] = 'http://www.zura.com.br/acessorios-para-acabamento.html';
            $words["Acess&oacute;rios Para Alimenta&ccedil;&atilde;o"] = 'http://www.zura.com.br/acessorios-para-alimentacao.html';
            $words["Acess&oacute;rios Para &Aacute;udio E V&iacute;deo"] = 'http://www.zura.com.br/acessorios-para-audio-video.html';
            $words["Acess&oacute;rios Para Bicicleta"] = 'http://www.zura.com.br/acessorios-para-bicicleta.html';
            $words["Acess&oacute;rios Para Bonecas"] = 'http://www.zura.com.br/acessorios-para-bonecas.html';
            $words["Acess&oacute;rios Para Bonecos"] = 'http://www.zura.com.br/acessorios-para-bonecos.html';
            $words["Acess&oacute;rios Para C&acirc;meras"] = 'http://www.zura.com.br/acessorios-para-cameras.html';
            $words["Acess&oacute;rios Para Celular"] = 'http://www.zura.com.br/acessorios-para-celular.html';
            $words["Acess&oacute;rios Para Chupeta"] = 'http://www.zura.com.br/acessorios-para-chupeta.html';
            $words["Acess&oacute;rios Para Eletrodom&eacute;sticos"] = 'http://www.zura.com.br/acessorios-para-eletrodomesticos.html';
            $words["Acess&oacute;rios Para Esportes N&aacute;uticos"] = 'http://www.zura.com.br/acessorios-para-esportes-nauticos.html';
            $words["Acess&oacute;rios Para Filmadoras"] = 'http://www.zura.com.br/acessorios-para-filmadoras.html';
            $words["Acess&oacute;rios Para GPS"] = 'http://www.zura.com.br/acessorios-para-gps.html';
            $words["Acess&oacute;rios Para Joalheria"] = 'http://www.zura.com.br/acessorios-para-joalheria.html';
            $words["Acess&oacute;rios Para Mesa Digitalizadora"] = 'http://www.zura.com.br/acessorios-para-mesa-digitalizadora.html';
            $words["Acess&oacute;rios Para Motos"] = 'http://www.zura.com.br/acessorios-para-motos.html';
            $words["Acess&oacute;rios Para MP3 Player"] = 'http://www.zura.com.br/acessorios-para-mp3-player.html';
            $words["Acess&oacute;rios Para M&uacute;sica E Instrumentos"] = 'http://www.zura.com.br/acessorios-para-musica-instrumentos.html';
            $words["Acess&oacute;rios Para Notebooks"] = 'http://www.zura.com.br/acessorios-para-notebooks.html';
            $words["Acess&oacute;rios Para Palmtop E PDA"] = 'http://www.zura.com.br/acessorios-para-palmtop-pda.html';
            $words["Acess&oacute;rios Para Petiscos"] = 'http://www.zura.com.br/acessorios-para-petiscos.html';
            $words["Acess&oacute;rios Para Pintura"] = 'http://www.zura.com.br/acessorios-para-pintura.html';
            $words["Acess&oacute;rios Para Projetores"] = 'http://www.zura.com.br/acessorios-para-projetores.html';
            $words["Acess&oacute;rios Para Roupas, Cal&ccedil;ados E Acess&oacute;rios"] = 'http://www.zura.com.br/acessorios-para-roupas-calcados-acessorios.html';
            $words["Acess&oacute;rios Para Smartphone"] = 'http://www.zura.com.br/acessorios-para-smartphone.html';
            $words["Acess&oacute;rios Para Telefone"] = 'http://www.zura.com.br/acessorios-para-telefone.html';
            $words["Acess&oacute;rios Para V&iacute;deo Games"] = 'http://www.zura.com.br/acessorios-para-video-games.html';
            $words["Adaptadores Para Cabos"] = 'http://www.zura.com.br/adaptadores-para-cabos.html';
            $words["Adesivos De Parede"] = 'http://www.zura.com.br/adesivos-de-parede.html';
            $words["Agenda E Di&aacute;rio"] = 'http://www.zura.com.br/agenda-diario.html';
            $words["&Aacute;gua"] = 'http://www.zura.com.br/agua.html';
            $words["Alarme E Sistema De Vigil&acirc;ncia"] = 'http://www.zura.com.br/alarme-sistema-de-vigilancia.html';
            $words["&Aacute;lcool - ACRE"] = 'http://www.zura.com.br/alcool-acre.html';
            $words["&Aacute;lcool - ALAGOAS"] = 'http://www.zura.com.br/alcool-alagoas.html';
            $words["&Aacute;lcool - AMAP&Aacute;"] = 'http://www.zura.com.br/alcool-amapa.html';
            $words["&Aacute;lcool - AMAZONAS"] = 'http://www.zura.com.br/alcool-amazonas.html';
            $words["&Aacute;lcool - BAHIA"] = 'http://www.zura.com.br/alcool-bahia.html';
            $words["&Aacute;lcool - CEAR&Aacute;"] = 'http://www.zura.com.br/alcool-ceara.html';
            $words["&Aacute;lcool - DISTRITO FEDERAL"] = 'http://www.zura.com.br/alcool-distrito-federal.html';
            $words["&Aacute;lcool - ESP&Iacute;RITO SANTO"] = 'http://www.zura.com.br/alcool-espirito-santo.html';
            $words["&Aacute;lcool - GOI&Aacute;S"] = 'http://www.zura.com.br/alcool-goias.html';
            $words["&Aacute;lcool - MARANH&Atilde;O"] = 'http://www.zura.com.br/alcool-maranhao.html';
            $words["&Aacute;lcool - MATO GROSSO"] = 'http://www.zura.com.br/alcool-mato-grosso.html';
            $words["&Aacute;lcool - MATO GROSSO DO SUL"] = 'http://www.zura.com.br/alcool-mato-grosso-do-sul.html';
            $words["&Aacute;lcool - MINAS GERAIS"] = 'http://www.zura.com.br/alcool-minas-gerais.html';
            $words["&Aacute;lcool - PAR&Aacute;"] = 'http://www.zura.com.br/alcool-para.html';
            $words["&Aacute;lcool - PARA&Iacute;BA"] = 'http://www.zura.com.br/alcool-paraiba.html';
            $words["&Aacute;lcool - PARAN&Aacute;"] = 'http://www.zura.com.br/alcool-parana.html';
            $words["&Aacute;lcool - PERNAMBUCO"] = 'http://www.zura.com.br/alcool-pernambuco.html';
            $words["&Aacute;lcool - PIAU&Iacute;"] = 'http://www.zura.com.br/alcool-piaui.html';
            $words["&Aacute;lcool - RIO DE JANEIRO"] = 'http://www.zura.com.br/alcool-rio-de-janeiro.html';
            $words["&Aacute;lcool - RIO GRANDE DO NORTE"] = 'http://www.zura.com.br/alcool-rio-grande-do-norte.html';
            $words["&Aacute;lcool - RIO GRANDE DO SUL"] = 'http://www.zura.com.br/alcool-rio-grande-do-sul.html';
            $words["&Aacute;lcool - ROND&Ocirc;NIA"] = 'http://www.zura.com.br/alcool-rondonia.html';
            $words["&Aacute;lcool - RORAIMA"] = 'http://www.zura.com.br/alcool-roraima.html';
            $words["&Aacute;lcool - SANTA CATARINA"] = 'http://www.zura.com.br/alcool-santa-catarina.html';
            $words["&Aacute;lcool - S&Atilde;O PAULO"] = 'http://www.zura.com.br/alcool-sao-paulo.html';
            $words["&Aacute;lcool - SERGIPE"] = 'http://www.zura.com.br/alcool-sergipe.html';
            $words["&Aacute;lcool - TOCANTINS"] = 'http://www.zura.com.br/alcool-tocantins.html';
            $words["Alimenta&ccedil;&atilde;o Para Animais"] = 'http://www.zura.com.br/alimentacao-para-animais.html';
            $words["Alimento Infantil"] = 'http://www.zura.com.br/alimento-infantil.html';
            $words["Alt&iacute;metro / Bar&ocirc;metro"] = 'http://www.zura.com.br/altimetro-barometro.html';
            $words["Amplificadores E M&oacute;dulos "] = 'http://www.zura.com.br/amplificadores-modulos.html';
            $words["An&eacute;is Penianos"] = 'http://www.zura.com.br/aneis-penianos.html';
            $words["Anima&ccedil;&atilde;o - Aluguel"] = 'http://www.zura.com.br/animacao-aluguel.html';
            $words["Antenas E Acess&oacute;rios"] = 'http://www.zura.com.br/antenas-acessorios.html';
            $words["Anti-V&iacute;rus / Seguran&ccedil;a"] = 'http://www.zura.com.br/anti-virus-seguranca.html';
            $words["Apagadores"] = 'http://www.zura.com.br/apagadores.html';
            $words["Aparador De P&ecirc;los"] = 'http://www.zura.com.br/aparador-de-pelos.html';
            $words["Aparelhos De Jantar, Ch&aacute; E Caf&eacute;"] = 'http://www.zura.com.br/aparelhos-de-jantar-cha-cafe.html';
            $words["Aparelhos De Press&atilde;o"] = 'http://www.zura.com.br/aparelhos-de-pressao.html';
            $words["Apart-hot&eacute;is - BA"] = 'http://www.zura.com.br/apart-hoteis-ba.html';
            $words["Aplicativos / Utilit&aacute;rios"] = 'http://www.zura.com.br/aplicativos-utilitarios.html';
            $words["Apontador"] = 'http://www.zura.com.br/apontador.html';
            $words["Aquecedor De &Aacute;gua"] = 'http://www.zura.com.br/aquecedor-de-agua.html';
            $words["Aquecedor De Ambiente"] = 'http://www.zura.com.br/aquecedor-de-ambiente.html';
            $words["&Aacute;rea Administrativa"] = 'http://www.zura.com.br/area-administrativa.html';
            $words["&Aacute;rea Arquitetura"] = 'http://www.zura.com.br/area-arquitetura.html';
            $words["&Aacute;rea Assist&ecirc;ncia T&eacute;cnica"] = 'http://www.zura.com.br/area-assistencia-tecnica.html';
            $words["&Aacute;rea Atendimento"] = 'http://www.zura.com.br/area-atendimento.html';
            $words["&Aacute;rea Auditoria"] = 'http://www.zura.com.br/area-auditoria.html';
            $words["&Aacute;rea Banc&aacute;ria E Mercado Financeiro"] = 'http://www.zura.com.br/area-bancaria-mercado-financeiro.html';
            $words["&Aacute;rea Beleza E Est&eacute;tica"] = 'http://www.zura.com.br/area-beleza-estetica.html';
            $words["&Aacute;rea Biblioteconomia"] = 'http://www.zura.com.br/area-biblioteconomia.html';
            $words["&Aacute;rea Ci&ecirc;ncias Agr&aacute;rias E Agrobusiness"] = 'http://www.zura.com.br/area-ciencias-agrarias-agrobusiness.html';
            $words["&Aacute;rea Comercial E Vendas"] = 'http://www.zura.com.br/area-comercial-vendas.html';
            $words["&Aacute;rea Com&eacute;rcio Exterior E Rela&ccedil;&otilde;es Internacionais"] = 'http://www.zura.com.br/area-comercio-exterior-relacoes-internacionais.html';
            $words["&Aacute;rea Compras E Suprimentos"] = 'http://www.zura.com.br/area-compras-suprimentos.html';
            $words["&Aacute;rea Comunica&ccedil;&atilde;o E Publicidade"] = 'http://www.zura.com.br/area-comunicacao-publicidade.html';
            $words["&Aacute;rea Constru&ccedil;&atilde;o Civil"] = 'http://www.zura.com.br/area-construcao-civil.html';
            $words["&Aacute;rea Controle E Sistema De Qualidade"] = 'http://www.zura.com.br/area-controle-sistema-de-qualidade.html';
            $words["&Aacute;rea Cultural"] = 'http://www.zura.com.br/area-cultural.html';
            $words["&Aacute;rea Educa&ccedil;&atilde;o E Ensino"] = 'http://www.zura.com.br/area-educacao-ensino.html';
            $words["&Aacute;rea Enfermagem"] = 'http://www.zura.com.br/area-enfermagem.html';
            $words["&Aacute;rea Engenharia"] = 'http://www.zura.com.br/area-engenharia.html';
            $words["&Aacute;rea Engenharia Civil"] = 'http://www.zura.com.br/area-engenharia-civil.html';
            $words["&Aacute;rea Engenharia De Alimentos"] = 'http://www.zura.com.br/area-engenharia-de-alimentos.html';
            $words["&Aacute;rea Engenharia De Materiais E Qu&iacute;mica"] = 'http://www.zura.com.br/area-engenharia-de-materiais-quimica.html';
            $words["&Aacute;rea Engenharia De Produ&ccedil;&atilde;o"] = 'http://www.zura.com.br/area-engenharia-de-producao.html';
            $words["&Aacute;rea Engenharia Eletr&ocirc;nica E Computa&ccedil;&atilde;o"] = 'http://www.zura.com.br/area-engenharia-eletronica-computacao.html';
            $words["&Aacute;rea Esportes"] = 'http://www.zura.com.br/area-esportes.html';
            $words["&Aacute;rea Eventos"] = 'http://www.zura.com.br/area-eventos.html';
            $words["&Aacute;rea Financeira"] = 'http://www.zura.com.br/area-financeira.html';
            $words["&Aacute;rea Fisioterapia"] = 'http://www.zura.com.br/area-fisioterapia.html';
            $words["&Aacute;rea Fonoaudiologia"] = 'http://www.zura.com.br/area-fonoaudiologia.html';
            $words["&Aacute;rea Gr&aacute;fica"] = 'http://www.zura.com.br/area-grafica.html';
            $words["&Aacute;rea Hotelaria"] = 'http://www.zura.com.br/area-hotelaria.html';
            $words["&Aacute;rea Idiomas"] = 'http://www.zura.com.br/area-idiomas.html';
            $words["&Aacute;rea Ind&uacute;stria"] = 'http://www.zura.com.br/area-industria.html';
            $words["&Aacute;rea Inform&aacute;tica"] = 'http://www.zura.com.br/area-informatica.html';
            $words["&Aacute;rea Jornalismo"] = 'http://www.zura.com.br/area-jornalismo.html';
            $words["&Aacute;rea Jur&iacute;dica"] = 'http://www.zura.com.br/area-juridica.html';
            $words["&Aacute;rea Log&iacute;stica"] = 'http://www.zura.com.br/area-logistica.html';
            $words["&Aacute;rea Marketing"] = 'http://www.zura.com.br/area-marketing.html';
            $words["&Aacute;rea Medicina"] = 'http://www.zura.com.br/area-medicina.html';
            $words["&Aacute;rea Meio Ambiente E Biologia"] = 'http://www.zura.com.br/area-meio-ambiente-biologia.html';
            $words["&Aacute;rea Moda"] = 'http://www.zura.com.br/area-moda.html';
            $words["&Aacute;rea Nutri&ccedil;&atilde;o"] = 'http://www.zura.com.br/area-nutricao.html';
            $words["&Aacute;rea Odontologia"] = 'http://www.zura.com.br/area-odontologia.html';
            $words["&Aacute;rea Operacional"] = 'http://www.zura.com.br/area-operacional.html';
            $words["&Aacute;rea Psicologia"] = 'http://www.zura.com.br/area-psicologia.html';
            $words["&Aacute;rea Qu&iacute;mica"] = 'http://www.zura.com.br/area-quimica.html';
            $words["&Aacute;rea Recursos Humanos"] = 'http://www.zura.com.br/area-recursos-humanos.html';
            $words["&Aacute;rea Repositores"] = 'http://www.zura.com.br/area-repositores.html';
            $words["&Aacute;rea Sa&uacute;de"] = 'http://www.zura.com.br/area-saude.html';
            $words["&Aacute;rea Seguran&ccedil;a Do Trabalho"] = 'http://www.zura.com.br/area-seguranca-do-trabalho.html';
            $words["&Aacute;rea Seguran&ccedil;a Patrimonial E Pessoal"] = 'http://www.zura.com.br/area-seguranca-patrimonial-pessoal.html';
            $words["&Aacute;rea Seguros"] = 'http://www.zura.com.br/area-seguros.html';
            $words["&Aacute;rea Servi&ccedil;o Social"] = 'http://www.zura.com.br/area-servico-social.html';
            $words["&Aacute;rea Telecomunica&ccedil;&otilde;es"] = 'http://www.zura.com.br/area-telecomunicacoes.html';
            $words["&Aacute;rea Telemarketing E Call Center"] = 'http://www.zura.com.br/area-telemarketing-call-center.html';
            $words["&Aacute;rea Terapia Ocupacional"] = 'http://www.zura.com.br/area-terapia-ocupacional.html';
            $words["&Aacute;rea Terceiro Setor"] = 'http://www.zura.com.br/area-terceiro-setor.html';
            $words["&Aacute;rea Transportes"] = 'http://www.zura.com.br/area-transportes.html';
            $words["&Aacute;rea Turismo"] = 'http://www.zura.com.br/area-turismo.html';
            $words["&Aacute;rea Veterin&aacute;ria"] = 'http://www.zura.com.br/area-veterinaria.html';
            $words["Arm&aacute;rio"] = 'http://www.zura.com.br/armario.html';
            $words["Aromatizadores"] = 'http://www.zura.com.br/aromatizadores.html';
            $words["Arquivos"] = 'http://www.zura.com.br/arquivos.html';
            $words["Arranjo E Buqu&ecirc;"] = 'http://www.zura.com.br/arranjo-buque.html';
            $words["Artes Marciais - Aluguel"] = 'http://www.zura.com.br/artes-marciais-aluguel.html';
            $words["Artes Marciais / Lutas"] = 'http://www.zura.com.br/artes-marciais-lutas.html';
            $words["Artigos Cat&oacute;licos"] = 'http://www.zura.com.br/artigos-catolicos.html';
            $words["Artigos Descart&aacute;veis"] = 'http://www.zura.com.br/artigos-descartaveis.html';
            $words["Artigos Escolares"] = 'http://www.zura.com.br/artigos-escolares.html';
            $words["Artigos Evang&eacute;licos"] = 'http://www.zura.com.br/artigos-evangelicos.html';
            $words["Artigos Natalinos"] = 'http://www.zura.com.br/artigos-natalinos.html';
            $words["Artigos Para C&atilde;es"] = 'http://www.zura.com.br/artigos-para-caes.html';
            $words["Artigos Para Ferrets"] = 'http://www.zura.com.br/artigos-para-ferrets.html';
            $words["Artigos Para Festas"] = 'http://www.zura.com.br/artigos-para-festas.html';
            $words["Artigos Para Gatos"] = 'http://www.zura.com.br/artigos-para-gatos.html';
            $words["Artigos Para Mamadeira"] = 'http://www.zura.com.br/artigos-para-mamadeira.html';
            $words["Artigos Para P&aacute;scoa"] = 'http://www.zura.com.br/artigos-para-pascoa.html';
            $words["Atletismo / Jogging"] = 'http://www.zura.com.br/atletismo-jogging.html';
            $words["Audio Livro"] = 'http://www.zura.com.br/audio-livro.html';
            $words["Auto-pe&ccedil;as"] = 'http://www.zura.com.br/auto-pecas.html';
            $words["Automa&ccedil;&atilde;o Comercial"] = 'http://www.zura.com.br/automacao-comercial.html';
            $words["Autom&oacute;vel Novo"] = 'http://www.zura.com.br/automovel-novo.html';
            $words["Autom&oacute;vel Usado"] = 'http://www.zura.com.br/automovel-usado.html';
            $words["Autorama, Ferrorama E Pistas"] = 'http://www.zura.com.br/autorama-ferrorama-pistas.html';
            $words["Aventura - Aluguel"] = 'http://www.zura.com.br/aventura-aluguel.html';
            $words["Aventura Rom&acirc;ntica - Aluguel"] = 'http://www.zura.com.br/aventura-romantica-aluguel.html';
            $words["Bab&aacute; Eletr&ocirc;nica"] = 'http://www.zura.com.br/baba-eletronica.html';
            $words["Babador"] = 'http://www.zura.com.br/babador.html';
            $words["Balan&ccedil;a"] = 'http://www.zura.com.br/balanca.html';
            $words["Balas"] = 'http://www.zura.com.br/balas.html';
            $words["Bandeiras / Adesivos / P&ocirc;sters"] = 'http://www.zura.com.br/bandeiras-adesivos-posters.html';
            $words["Bandeja, Baixela E Travessas"] = 'http://www.zura.com.br/bandeja-baixela-travessas.html';
            $words["Banheira"] = 'http://www.zura.com.br/banheira.html';
            $words["Banheiro"] = 'http://www.zura.com.br/banheiro.html';
            $words["Banheiro E Cozinhas"] = 'http://www.zura.com.br/banheiro-cozinhas.html';
            $words["Banho"] = 'http://www.zura.com.br/banho.html';
            $words["Banho Do Beb&ecirc;"] = 'http://www.zura.com.br/banho-do-bebe.html';
            $words["Bar"] = 'http://www.zura.com.br/bar.html';
            $words["Barba"] = 'http://www.zura.com.br/barba.html';
            $words["Barbeador El&eacute;trico"] = 'http://www.zura.com.br/barbeador-eletrico.html';
            $words["Barcos / Canoagem"] = 'http://www.zura.com.br/barcos-canoagem.html';
            $words["Barracas E Tocas"] = 'http://www.zura.com.br/barracas-tocas.html';
            $words["Base Para Maquiagem"] = 'http://www.zura.com.br/base-para-maquiagem.html';
            $words["Basquete"] = 'http://www.zura.com.br/basquete.html';
            $words["Batom"] = 'http://www.zura.com.br/batom.html';
            $words["Beb&ecirc; Conforto"] = 'http://www.zura.com.br/bebe-conforto.html';
            $words["Bebida Energ&eacute;tica"] = 'http://www.zura.com.br/bebida-energetica.html';
            $words["Ber&ccedil;os E Cercados"] = 'http://www.zura.com.br/bercos-cercados.html';
            $words["Bicicleta Ergom&eacute;trica"] = 'http://www.zura.com.br/bicicleta-ergometrica.html';
            $words["Bicicleta Motorizada"] = 'http://www.zura.com.br/bicicleta-motorizada.html';
            $words["Bijuterias"] = 'http://www.zura.com.br/bijuterias.html';
            $words["Bilhar / Sinuca"] = 'http://www.zura.com.br/bilhar-sinuca.html';
            $words["Bin&oacute;culo / Luneta"] = 'http://www.zura.com.br/binoculo-luneta.html';
            $words["Biografia - Aluguel"] = 'http://www.zura.com.br/biografia-aluguel.html';
            $words["Biscoitos "] = 'http://www.zura.com.br/biscoitos.html';
            $words["Blocos De Montar"] = 'http://www.zura.com.br/blocos-de-montar.html';
            $words["Blush"] = 'http://www.zura.com.br/blush.html';
            $words["Bola De Basquete"] = 'http://www.zura.com.br/bola-de-basquete.html';
            $words["Bola De Frescobol"] = 'http://www.zura.com.br/bola-de-frescobol.html';
            $words["Bola De Futebol"] = 'http://www.zura.com.br/bola-de-futebol.html';
            $words["Bola De Futebol Americano"] = 'http://www.zura.com.br/bola-de-futebol-americano.html';
            $words["Bola De Futsal"] = 'http://www.zura.com.br/bola-de-futsal.html';
            $words["Bola De Golfe"] = 'http://www.zura.com.br/bola-de-golfe.html';
            $words["Bola De Handball"] = 'http://www.zura.com.br/bola-de-handball.html';
            $words["Bola De Ping-pong"] = 'http://www.zura.com.br/bola-de-ping-pong.html';
            $words["Bola De T&ecirc;nis"] = 'http://www.zura.com.br/bola-de-tenis.html';
            $words["Bola De V&ocirc;lei"] = 'http://www.zura.com.br/bola-de-volei.html';
            $words["Bola Infantil"] = 'http://www.zura.com.br/bola-infantil.html';
            $words["Bolsa Para Beb&ecirc;"] = 'http://www.zura.com.br/bolsa-para-bebe.html';
            $words["Bolsas E Malas"] = 'http://www.zura.com.br/bolsas-malas.html';
            $words["Bombas E Compressores"] = 'http://www.zura.com.br/bombas-compressores.html';
            $words["Bombas Penianas / Extensores"] = 'http://www.zura.com.br/bombas-penianas-extensores.html';
            $words["Bonecos Colecionaveis"] = 'http://www.zura.com.br/bonecos-colecionaveis.html';
            $words["Bonecos E Personagens"] = 'http://www.zura.com.br/bonecos-personagens.html';
            $words["Bordados"] = 'http://www.zura.com.br/bordados.html';
            $words["Borrachas"] = 'http://www.zura.com.br/borrachas.html';
            $words["Brincadeira De Menina E Menino"] = 'http://www.zura.com.br/brincadeira-de-menina-menino.html';
            $words["Brincadeiras Er&oacute;ticas"] = 'http://www.zura.com.br/brincadeiras-eroticas.html';
            $words["Brinquedos De Beb&ecirc;"] = 'http://www.zura.com.br/brinquedos-de-bebe.html';
            $words["Brinquedos Eletr&ocirc;nicos"] = 'http://www.zura.com.br/brinquedos-eletronicos.html';
            $words["B&uacute;ssola"] = 'http://www.zura.com.br/bussola.html';
            $words["Cabides"] = 'http://www.zura.com.br/cabides.html';
            $words["Cabos"] = 'http://www.zura.com.br/cabos.html';
            $words["Cabos Para &Aacute;udio E V&iacute;deo"] = 'http://www.zura.com.br/cabos-para-audio-video.html';
            $words["Ca&ccedil;a E Pesca"] = 'http://www.zura.com.br/caca-pesca.html';
            $words["Cacha&ccedil;a E Aguardente"] = 'http://www.zura.com.br/cachaca-aguardente.html';
            $words["Cadeira De Rodas"] = 'http://www.zura.com.br/cadeira-de-rodas.html';
            $words["Cadeira Para Alimenta&ccedil;&atilde;o"] = 'http://www.zura.com.br/cadeira-para-alimentacao.html';
            $words["Cadeiras"] = 'http://www.zura.com.br/cadeiras.html';
            $words["Caderno E Bloco"] = 'http://www.zura.com.br/caderno-bloco.html';
            $words["Caixa Ac&uacute;stica"] = 'http://www.zura.com.br/caixa-acustica.html';
            $words["Caixa De Som Para PC"] = 'http://www.zura.com.br/caixa-de-som-para-pc.html';
            $words["Cal&ccedil;ado Masculino"] = 'http://www.zura.com.br/calcado-masculino.html';
            $words["Cal&ccedil;ado Unissex"] = 'http://www.zura.com.br/calcado-unissex.html';
            $words["Cal&ccedil;ados Para Beb&ecirc;"] = 'http://www.zura.com.br/calcados-para-bebe.html';
            $words["Calculadora"] = 'http://www.zura.com.br/calculadora.html';
            $words["Cama"] = 'http://www.zura.com.br/cama.html';
            $words["Cama El&aacute;stica"] = 'http://www.zura.com.br/cama-elastica.html';
            $words["C&acirc;mera Fotogr&aacute;fica"] = 'http://www.zura.com.br/camera-fotografica.html';
            $words["Caminh&atilde;o Usado"] = 'http://www.zura.com.br/caminhao-usado.html';
            $words["Camping"] = 'http://www.zura.com.br/camping.html';
            $words["Caneta"] = 'http://www.zura.com.br/caneta.html';
            $words["Canivete"] = 'http://www.zura.com.br/canivete.html';
            $words["Capacetes"] = 'http://www.zura.com.br/capacetes.html';
            $words["Capas"] = 'http://www.zura.com.br/capas.html';
            $words["Capas E Telas Para PC"] = 'http://www.zura.com.br/capas-telas-para-pc.html';
            $words["Card Games"] = 'http://www.zura.com.br/card-games.html';
            $words["Carimbos"] = 'http://www.zura.com.br/carimbos.html';
            $words["Carnes"] = 'http://www.zura.com.br/carnes.html';
            $words["Carregadores E Baterias Para Notebook"] = 'http://www.zura.com.br/carregadores-baterias-para-notebook.html';
            $words["Carregadores, Pilhas E Baterias"] = 'http://www.zura.com.br/carregadores-pilhas-baterias.html';
            $words["Carrinho"] = 'http://www.zura.com.br/carrinho.html';
            $words["Carrinho E Ve&iacute;culo"] = 'http://www.zura.com.br/carrinho-veiculo.html';
            $words["Carro E Triciclo"] = 'http://www.zura.com.br/carro-triciclo.html';
            $words["Carros Miniaturas E Colecion&aacute;veis"] = 'http://www.zura.com.br/carros-miniaturas-colecionaveis.html';
            $words["Cartas (Baralho)"] = 'http://www.zura.com.br/cartas-baralho.html';
            $words["Cart&otilde;es"] = 'http://www.zura.com.br/cartoes.html';
            $words["Cartucho"] = 'http://www.zura.com.br/cartucho.html';
            $words["CD"] = 'http://www.zura.com.br/cd.html';
            $words["CD Player"] = 'http://www.zura.com.br/cd-player.html';
            $words["Centrais Telef&ocirc;nicas / PABX"] = 'http://www.zura.com.br/centrais-telefonicas-pabx.html';
            $words["Centr&iacute;fuga De Alimentos"] = 'http://www.zura.com.br/centrifuga-de-alimentos.html';
            $words["Cereais E Barras De Cereais"] = 'http://www.zura.com.br/cereais-barras-de-cereais.html';
            $words["Cerveja"] = 'http://www.zura.com.br/cerveja.html';
            $words["Chaleiras El&eacute;tricas"] = 'http://www.zura.com.br/chaleiras-eletricas.html';
            $words["Champagne E Espumantes"] = 'http://www.zura.com.br/champagne-espumantes.html';
            $words["Chaveiros"] = 'http://www.zura.com.br/chaveiros.html';
            $words["Chips Avulsos"] = 'http://www.zura.com.br/chips-avulsos.html';
            $words["Chocolates E Bombons"] = 'http://www.zura.com.br/chocolates-bombons.html';
            $words["Chopeiras"] = 'http://www.zura.com.br/chopeiras.html';
            $words["Chupeta"] = 'http://www.zura.com.br/chupeta.html';
            $words["Churrasco"] = 'http://www.zura.com.br/churrasco.html';
            $words["Chuveiro E Ducha"] = 'http://www.zura.com.br/chuveiro-ducha.html';
            $words["C&iacute;lios"] = 'http://www.zura.com.br/cilios.html';
            $words["Circulador E Ventilador"] = 'http://www.zura.com.br/circulador-ventilador.html';
            $words["Cl&aacute;ssicos - Aluguel"] = 'http://www.zura.com.br/classicos-aluguel.html';
            $words["Clips, Tachinhas E El&aacute;sticos"] = 'http://www.zura.com.br/clips-tachinhas-elasticos.html';
            $words["Cobertor"] = 'http://www.zura.com.br/cobertor.html';
            $words["Cola"] = 'http://www.zura.com.br/cola.html';
            $words["Colcha"] = 'http://www.zura.com.br/colcha.html';
            $words["Colchas, Edredon &amp; Cobertores"] = 'http://www.zura.com.br/colchas-edredon-cobertores.html';
            $words["Colch&otilde;es"] = 'http://www.zura.com.br/colchoes.html';
            $words["Colora&ccedil;&otilde;es Para Cabelo"] = 'http://www.zura.com.br/coloracoes-para-cabelo.html';
            $words["Com&eacute;dia - Aluguel"] = 'http://www.zura.com.br/comedia-aluguel.html';
            $words["Com&eacute;dia Dram&aacute;tica - Aluguel"] = 'http://www.zura.com.br/comedia-dramatica-aluguel.html';
            $words["Com&eacute;dia Infantil - Aluguel"] = 'http://www.zura.com.br/comedia-infantil-aluguel.html';
            $words["Com&eacute;dia Rom&acirc;ntica - Aluguel"] = 'http://www.zura.com.br/comedia-romantica-aluguel.html';
            $words["Condicionador"] = 'http://www.zura.com.br/condicionador.html';
            $words["Condicionador De Energia"] = 'http://www.zura.com.br/condicionador-de-energia.html';
            $words["Confer&ecirc;ncia"] = 'http://www.zura.com.br/conferencia.html';
            $words["Congelados"] = 'http://www.zura.com.br/congelados.html';
            $words["Controle Remoto"] = 'http://www.zura.com.br/controle-remoto.html';
            $words["Cooler"] = 'http://www.zura.com.br/cooler.html';
            $words["Cooler Para Notebook"] = 'http://www.zura.com.br/cooler-para-notebook.html';
            $words["Cooler Para PC"] = 'http://www.zura.com.br/cooler-para-pc.html';
            $words["Copiadoras"] = 'http://www.zura.com.br/copiadoras.html';
            $words["Copos Para Beb&ecirc;s"] = 'http://www.zura.com.br/copos-para-bebes.html';
            $words["Copos, Ta&ccedil;as,  Canecas E Baldes"] = 'http://www.zura.com.br/copos-tacas-canecas-baldes.html';
            $words["Corpo E Pele"] = 'http://www.zura.com.br/corpo-pele.html';
            $words["Corretivo Facial"] = 'http://www.zura.com.br/corretivo-facial.html';
            $words["Corretivos"] = 'http://www.zura.com.br/corretivos.html';
            $words["Cortador De Grama"] = 'http://www.zura.com.br/cortador-de-grama.html';
            $words["Cortina De Ar"] = 'http://www.zura.com.br/cortina-de-ar.html';
            $words["Cortinas"] = 'http://www.zura.com.br/cortinas.html';
            $words["Cozinha Oriental"] = 'http://www.zura.com.br/cozinha-oriental.html';
            $words["Creme De Pentear"] = 'http://www.zura.com.br/creme-de-pentear.html';
            $words["Cron&ocirc;metro"] = 'http://www.zura.com.br/cronometro.html';
            $words["Cuidados E Terapias"] = 'http://www.zura.com.br/cuidados-terapias.html';
            $words["Curativos"] = 'http://www.zura.com.br/curativos.html';
            $words["Curso De L&iacute;nguas"] = 'http://www.zura.com.br/curso-de-linguas.html';
            $words["Cursos Em CD-Rom"] = 'http://www.zura.com.br/cursos-em-cd-rom.html';
            $words["Cursos Em DVD"] = 'http://www.zura.com.br/cursos-em-dvd.html';
            $words["Curvex"] = 'http://www.zura.com.br/curvex.html';
            $words["Decodificador"] = 'http://www.zura.com.br/decodificador.html';
            $words["Decora&ccedil;&atilde;o"] = 'http://www.zura.com.br/decoracao.html';
            $words["Decora&ccedil;&atilde;o Para Quarto"] = 'http://www.zura.com.br/decoracao-para-quarto.html';
            $words["Delineador Para L&aacute;bios"] = 'http://www.zura.com.br/delineador-para-labios.html';
            $words["Delineador Para Olhos"] = 'http://www.zura.com.br/delineador-para-olhos.html';
            $words["Demaquilante"] = 'http://www.zura.com.br/demaquilante.html';
            $words["Depiladores"] = 'http://www.zura.com.br/depiladores.html';
            $words["Depurador De Ar E Coifa"] = 'http://www.zura.com.br/depurador-de-ar-coifa.html';
            $words["Desenho Animado - Aluguel"] = 'http://www.zura.com.br/desenho-animado-aluguel.html';
            $words["Despertador"] = 'http://www.zura.com.br/despertador.html';
            $words["Desumidificador"] = 'http://www.zura.com.br/desumidificador.html';
            $words["Diesel - ACRE"] = 'http://www.zura.com.br/diesel-acre.html';
            $words["Diesel - ALAGOAS"] = 'http://www.zura.com.br/diesel-alagoas.html';
            $words["Diesel - AMAP&Aacute;"] = 'http://www.zura.com.br/diesel-amapa.html';
            $words["Diesel - AMAZONAS"] = 'http://www.zura.com.br/diesel-amazonas.html';
            $words["Diesel - BAHIA"] = 'http://www.zura.com.br/diesel-bahia.html';
            $words["Diesel - CEAR&Aacute;"] = 'http://www.zura.com.br/diesel-ceara.html';
            $words["Diesel - DISTRITO FEDERAL"] = 'http://www.zura.com.br/diesel-distrito-federal.html';
            $words["Diesel - ESP&Iacute;RITO SANTO"] = 'http://www.zura.com.br/diesel-espirito-santo.html';
            $words["Diesel - GOI&Aacute;S"] = 'http://www.zura.com.br/diesel-goias.html';
            $words["Diesel - MARANH&Atilde;O"] = 'http://www.zura.com.br/diesel-maranhao.html';
            $words["Diesel - MATO GROSSO"] = 'http://www.zura.com.br/diesel-mato-grosso.html';
            $words["Diesel - MATO GROSSO DO SUL"] = 'http://www.zura.com.br/diesel-mato-grosso-do-sul.html';
            $words["Diesel - MINAS GERAIS"] = 'http://www.zura.com.br/diesel-minas-gerais.html';
            $words["Diesel - PAR&Aacute;"] = 'http://www.zura.com.br/diesel-para.html';
            $words["Diesel - PARA&Iacute;BA"] = 'http://www.zura.com.br/diesel-paraiba.html';
            $words["Diesel - PARAN&Aacute;"] = 'http://www.zura.com.br/diesel-parana.html';
            $words["Diesel - PERNAMBUCO"] = 'http://www.zura.com.br/diesel-pernambuco.html';
            $words["Diesel - PIAU&Iacute;"] = 'http://www.zura.com.br/diesel-piaui.html';
            $words["Diesel - RIO DE JANEIRO"] = 'http://www.zura.com.br/diesel-rio-de-janeiro.html';
            $words["Diesel - RIO GRANDE DO NORTE"] = 'http://www.zura.com.br/diesel-rio-grande-do-norte.html';
            $words["Diesel - RIO GRANDE DO SUL"] = 'http://www.zura.com.br/diesel-rio-grande-do-sul.html';
            $words["Diesel - ROND&Ocirc;NIA"] = 'http://www.zura.com.br/diesel-rondonia.html';
            $words["Diesel - RORAIMA"] = 'http://www.zura.com.br/diesel-roraima.html';
            $words["Diesel - SANTA CATARINA"] = 'http://www.zura.com.br/diesel-santa-catarina.html';
            $words["Diesel - S&Atilde;O PAULO"] = 'http://www.zura.com.br/diesel-sao-paulo.html';
            $words["Diesel - SERGIPE"] = 'http://www.zura.com.br/diesel-sergipe.html';
            $words["Diesel - TOCANTINS"] = 'http://www.zura.com.br/diesel-tocantins.html';
            $words["Document&aacute;rio - Aluguel"] = 'http://www.zura.com.br/documentario-aluguel.html';
            $words["Download"] = 'http://www.zura.com.br/download.html';
            $words["Drama - Aluguel"] = 'http://www.zura.com.br/drama-aluguel.html';
            $words["Drive Gravador De CD / DVD"] = 'http://www.zura.com.br/drive-gravador-de-cd-dvd.html';
            $words["Drive Leitor De CD / DVD"] = 'http://www.zura.com.br/drive-leitor-de-cd-dvd.html';
            $words["Drivers, Cornetas E Tweeters"] = 'http://www.zura.com.br/drivers-cornetas-tweeters.html';
            $words["DVD"] = 'http://www.zura.com.br/dvd.html';
            $words["DVD / VHS Er&oacute;tico"] = 'http://www.zura.com.br/dvd-vhs-erotico.html';
            $words["DVD Player"] = 'http://www.zura.com.br/dvd-player.html';
            $words["DVD Player Automotivo"] = 'http://www.zura.com.br/dvd-player-automotivo.html';
            $words["Ebook"] = 'http://www.zura.com.br/ebook.html';
            $words["Edredon"] = 'http://www.zura.com.br/edredon.html';
            $words["Educacional - Aluguel"] = 'http://www.zura.com.br/educacional-aluguel.html';
            $words["El&iacute;ptico"] = 'http://www.zura.com.br/eliptico.html';
            $words["Emagrecedor / Shakes"] = 'http://www.zura.com.br/emagrecedor-shakes.html';
            $words["Encadernadora"] = 'http://www.zura.com.br/encadernadora.html';
            $words["Enceradeira"] = 'http://www.zura.com.br/enceradeira.html';
            $words["Envelope"] = 'http://www.zura.com.br/envelope.html';
            $words["&Eacute;pico - Aluguel"] = 'http://www.zura.com.br/epico-aluguel.html';
            $words["Equalizador"] = 'http://www.zura.com.br/equalizador.html';
            $words["Equipamento De Artesanato"] = 'http://www.zura.com.br/equipamento-de-artesanato.html';
            $words["Equipamentos / Limpeza De Piscina"] = 'http://www.zura.com.br/equipamentos-limpeza-de-piscina.html';
            $words["Equipamentos E M&aacute;quinas"] = 'http://www.zura.com.br/equipamentos-maquinas.html';
            $words["Equipamentos Hospitalares E Laboratoriais"] = 'http://www.zura.com.br/equipamentos-hospitalares-laboratoriais.html';
            $words["Equipamentos Para Com&eacute;rcio"] = 'http://www.zura.com.br/equipamentos-para-comercio.html';
            $words["Equipamentos Para DJs"] = 'http://www.zura.com.br/equipamentos-para-djs.html';
            $words["Equipamentos Para Voip"] = 'http://www.zura.com.br/equipamentos-para-voip.html';
            $words["Equita&ccedil;&atilde;o"] = 'http://www.zura.com.br/equitacao.html';
            $words["Escada"] = 'http://www.zura.com.br/escada.html';
            $words["Escalada, Trilha E Montanhismo"] = 'http://www.zura.com.br/escalada-trilha-montanhismo.html';
            $words["Escrivaninha / Mesa Para Computador"] = 'http://www.zura.com.br/escrivaninha-mesa-para-computador.html';
            $words["Espa&ccedil;o - Aluguel"] = 'http://www.zura.com.br/espaco-aluguel.html';
            $words["Espelhos"] = 'http://www.zura.com.br/espelhos.html';
            $words["Esponja"] = 'http://www.zura.com.br/esponja.html';
            $words["Esponja Para Maquiagem"] = 'http://www.zura.com.br/esponja-para-maquiagem.html';
            $words["Esportes - Aluguel"] = 'http://www.zura.com.br/esportes-aluguel.html';
            $words["Espremedor De Frutas"] = 'http://www.zura.com.br/espremedor-de-frutas.html';
            $words["Espuma De Banho"] = 'http://www.zura.com.br/espuma-de-banho.html';
            $words["Esqui Aqu&aacute;tico / Wakeboard"] = 'http://www.zura.com.br/esqui-aquatico-wakeboard.html';
            $words["Estabilizador"] = 'http://www.zura.com.br/estabilizador.html';
            $words["Estante"] = 'http://www.zura.com.br/estante.html';
            $words["Esteira"] = 'http://www.zura.com.br/esteira.html';
            $words["Esterilizador E Purificador De Ar"] = 'http://www.zura.com.br/esterilizador-purificador-de-ar.html';
            $words["Estiletes"] = 'http://www.zura.com.br/estiletes.html';
            $words["Estojo Escolar"] = 'http://www.zura.com.br/estojo-escolar.html';
            $words["Etiqueta"] = 'http://www.zura.com.br/etiqueta.html';
            $words["Etiquetadora"] = 'http://www.zura.com.br/etiquetadora.html';
            $words["Eventos"] = 'http://www.zura.com.br/eventos.html';
            $words["Fantasias E Acess&oacute;rios"] = 'http://www.zura.com.br/fantasias-acessorios.html';
            $words["Farol / Lanterna Para Autom&oacute;veis"] = 'http://www.zura.com.br/farol-lanterna-para-automoveis.html';
            $words["Ferragens"] = 'http://www.zura.com.br/ferragens.html';
            $words["Ferramentas De Medi&ccedil;&atilde;o"] = 'http://www.zura.com.br/ferramentas-de-medicao.html';
            $words["Ferramentas El&eacute;tricas"] = 'http://www.zura.com.br/ferramentas-eletricas.html';
            $words["Ferramentas Manuais"] = 'http://www.zura.com.br/ferramentas-manuais.html';
            $words["Ferro / M&aacute;quina De Solda E Acess&oacute;rios"] = 'http://www.zura.com.br/ferro-maquina-de-solda-acessorios.html';
            $words["Fic&ccedil;&atilde;o - Aluguel"] = 'http://www.zura.com.br/ficcao-aluguel.html';
            $words["Fic&ccedil;&atilde;o Cient&iacute;fica - Aluguel"] = 'http://www.zura.com.br/ficcao-cientifica-aluguel.html';
            $words["Fich&aacute;rio"] = 'http://www.zura.com.br/fichario.html';
            $words["Fichas"] = 'http://www.zura.com.br/fichas.html';
            $words["Filmadoras"] = 'http://www.zura.com.br/filmadoras.html';
            $words["Filme Infantil"] = 'http://www.zura.com.br/filme-infantil.html';
            $words["Filtro De Linha"] = 'http://www.zura.com.br/filtro-de-linha.html';
            $words["Filtros"] = 'http://www.zura.com.br/filtros.html';
            $words["Fita Matricial"] = 'http://www.zura.com.br/fita-matricial.html';
            $words["Fitas Adesivas"] = 'http://www.zura.com.br/fitas-adesivas.html';
            $words["Flashes"] = 'http://www.zura.com.br/flashes.html';
            $words["Flats - CE"] = 'http://www.zura.com.br/flats-ce.html';
            $words["Flats - DF"] = 'http://www.zura.com.br/flats-df.html';
            $words["Flats - ES"] = 'http://www.zura.com.br/flats-es.html';
            $words["Flats - MG"] = 'http://www.zura.com.br/flats-mg.html';
            $words["Flats - PR"] = 'http://www.zura.com.br/flats-pr.html';
            $words["Flats - SC"] = 'http://www.zura.com.br/flats-sc.html';
            $words["Flats - SP"] = 'http://www.zura.com.br/flats-sp.html';
            $words["Floppy Drive"] = 'http://www.zura.com.br/floppy-drive.html';
            $words["Flores E Cestas Para Presentes"] = 'http://www.zura.com.br/flores-cestas-para-presentes.html';
            $words["Fog&otilde;es"] = 'http://www.zura.com.br/fogoes.html';
            $words["Fondue"] = 'http://www.zura.com.br/fondue.html';
            $words["Fone De Ouvido"] = 'http://www.zura.com.br/fone-de-ouvido.html';
            $words["Fonte De Chocolate"] = 'http://www.zura.com.br/fonte-de-chocolate.html';
            $words["Fontes Alimenta&ccedil;&atilde;o"] = 'http://www.zura.com.br/fontes-alimentacao.html';
            $words["Formul&aacute;rios"] = 'http://www.zura.com.br/formularios.html';
            $words["Forno A G&aacute;s"] = 'http://www.zura.com.br/forno-a-gas.html';
            $words["Fraldas"] = 'http://www.zura.com.br/fraldas.html';
            $words["Frisbees E Discos De Praia"] = 'http://www.zura.com.br/frisbees-discos-de-praia.html';
            $words["Fronha"] = 'http://www.zura.com.br/fronha.html';
            $words["Furadeira"] = 'http://www.zura.com.br/furadeira.html';
            $words["Futebol - Aluguel"] = 'http://www.zura.com.br/futebol-aluguel.html';
            $words["Futebol / Futsal"] = 'http://www.zura.com.br/futebol-futsal.html';
            $words["Futebol De Bot&atilde;o"] = 'http://www.zura.com.br/futebol-de-botao.html';
            $words["Gabinete"] = 'http://www.zura.com.br/gabinete.html';
            $words["Gasolina - ACRE"] = 'http://www.zura.com.br/gasolina-acre.html';
            $words["Gasolina - ALAGOAS"] = 'http://www.zura.com.br/gasolina-alagoas.html';
            $words["Gasolina - AMAP&Aacute;"] = 'http://www.zura.com.br/gasolina-amapa.html';
            $words["Gasolina - AMAZONAS"] = 'http://www.zura.com.br/gasolina-amazonas.html';
            $words["Gasolina - BAHIA"] = 'http://www.zura.com.br/gasolina-bahia.html';
            $words["Gasolina - CEAR&Aacute;"] = 'http://www.zura.com.br/gasolina-ceara.html';
            $words["Gasolina - DISTRITO FEDERAL"] = 'http://www.zura.com.br/gasolina-distrito-federal.html';
            $words["Gasolina - ESP&Iacute;RITO SANTO"] = 'http://www.zura.com.br/gasolina-espirito-santo.html';
            $words["Gasolina - GOI&Aacute;S"] = 'http://www.zura.com.br/gasolina-goias.html';
            $words["Gasolina - MARANH&Atilde;O"] = 'http://www.zura.com.br/gasolina-maranhao.html';
            $words["Gasolina - MATO GROSSO"] = 'http://www.zura.com.br/gasolina-mato-grosso.html';
            $words["Gasolina - MATO GROSSO DO SUL"] = 'http://www.zura.com.br/gasolina-mato-grosso-do-sul.html';
            $words["Gasolina - MINAS GERAIS"] = 'http://www.zura.com.br/gasolina-minas-gerais.html';
            $words["Gasolina - PAR&Aacute;"] = 'http://www.zura.com.br/gasolina-para.html';
            $words["Gasolina - PARA&Iacute;BA"] = 'http://www.zura.com.br/gasolina-paraiba.html';
            $words["Gasolina - PARAN&Aacute;"] = 'http://www.zura.com.br/gasolina-parana.html';
            $words["Gasolina - PERNAMBUCO"] = 'http://www.zura.com.br/gasolina-pernambuco.html';
            $words["Gasolina - PIAU&Iacute;"] = 'http://www.zura.com.br/gasolina-piaui.html';
            $words["Gasolina - RIO DE JANEIRO"] = 'http://www.zura.com.br/gasolina-rio-de-janeiro.html';
            $words["Gasolina - RIO GRANDE DO NORTE"] = 'http://www.zura.com.br/gasolina-rio-grande-do-norte.html';
            $words["Gasolina - RIO GRANDE DO SUL"] = 'http://www.zura.com.br/gasolina-rio-grande-do-sul.html';
            $words["Gasolina - ROND&Ocirc;NIA"] = 'http://www.zura.com.br/gasolina-rondonia.html';
            $words["Gasolina - RORAIMA"] = 'http://www.zura.com.br/gasolina-roraima.html';
            $words["Gasolina - SANTA CATARINA"] = 'http://www.zura.com.br/gasolina-santa-catarina.html';
            $words["Gasolina - S&Atilde;O PAULO"] = 'http://www.zura.com.br/gasolina-sao-paulo.html';
            $words["Gasolina - SERGIPE"] = 'http://www.zura.com.br/gasolina-sergipe.html';
            $words["Gasolina - TOCANTINS"] = 'http://www.zura.com.br/gasolina-tocantins.html';
            $words["Geradores"] = 'http://www.zura.com.br/geradores.html';
            $words["Gin&aacute;stica E Muscula&ccedil;&atilde;o"] = 'http://www.zura.com.br/ginastica-musculacao.html';
            $words["Gloss E Brilho Labial"] = 'http://www.zura.com.br/gloss-brilho-labial.html';
            $words["GLP - ACRE"] = 'http://www.zura.com.br/glp-acre.html';
            $words["GLP - ALAGOAS"] = 'http://www.zura.com.br/glp-alagoas.html';
            $words["GLP - AMAP&Aacute;"] = 'http://www.zura.com.br/glp-amapa.html';
            $words["GLP - AMAZONAS"] = 'http://www.zura.com.br/glp-amazonas.html';
            $words["GLP - BAHIA"] = 'http://www.zura.com.br/glp-bahia.html';
            $words["GLP - CEAR&Aacute;"] = 'http://www.zura.com.br/glp-ceara.html';
            $words["GLP - DISTRITO FEDERAL"] = 'http://www.zura.com.br/glp-distrito-federal.html';
            $words["GLP - ESP&Iacute;RITO SANTO"] = 'http://www.zura.com.br/glp-espirito-santo.html';
            $words["GLP - GOI&Aacute;S"] = 'http://www.zura.com.br/glp-goias.html';
            $words["GLP - MARANH&Atilde;O"] = 'http://www.zura.com.br/glp-maranhao.html';
            $words["GLP - MATO GROSSO"] = 'http://www.zura.com.br/glp-mato-grosso.html';
            $words["GLP - MATO GROSSO DO SUL"] = 'http://www.zura.com.br/glp-mato-grosso-do-sul.html';
            $words["GLP - MINAS GERAIS"] = 'http://www.zura.com.br/glp-minas-gerais.html';
            $words["GLP - PAR&Aacute;"] = 'http://www.zura.com.br/glp-para.html';
            $words["GLP - PARA&Iacute;BA"] = 'http://www.zura.com.br/glp-paraiba.html';
            $words["GLP - PARAN&Aacute;"] = 'http://www.zura.com.br/glp-parana.html';
            $words["GLP - PERNAMBUCO"] = 'http://www.zura.com.br/glp-pernambuco.html';
            $words["GLP - PIAU&Iacute;"] = 'http://www.zura.com.br/glp-piaui.html';
            $words["GLP - RIO DE JANEIRO"] = 'http://www.zura.com.br/glp-rio-de-janeiro.html';
            $words["GLP - RIO GRANDE DO NORTE"] = 'http://www.zura.com.br/glp-rio-grande-do-norte.html';
            $words["GLP - RIO GRANDE DO SUL"] = 'http://www.zura.com.br/glp-rio-grande-do-sul.html';
            $words["GLP - ROND&Ocirc;NIA"] = 'http://www.zura.com.br/glp-rondonia.html';
            $words["GLP - RORAIMA"] = 'http://www.zura.com.br/glp-roraima.html';
            $words["GLP - SANTA CATARINA"] = 'http://www.zura.com.br/glp-santa-catarina.html';
            $words["GLP - S&Atilde;O PAULO"] = 'http://www.zura.com.br/glp-sao-paulo.html';
            $words["GLP - SERGIPE"] = 'http://www.zura.com.br/glp-sergipe.html';
            $words["GLP - TOCANTINS"] = 'http://www.zura.com.br/glp-tocantins.html';
            $words["GNV - ACRE"] = 'http://www.zura.com.br/gnv-acre.html';
            $words["GNV - ALAGOAS"] = 'http://www.zura.com.br/gnv-alagoas.html';
            $words["GNV - AMAZONAS"] = 'http://www.zura.com.br/gnv-amazonas.html';
            $words["GNV - BAHIA"] = 'http://www.zura.com.br/gnv-bahia.html';
            $words["GNV - CEAR&Aacute;"] = 'http://www.zura.com.br/gnv-ceara.html';
            $words["GNV - ESP&Iacute;RITO SANTO"] = 'http://www.zura.com.br/gnv-espirito-santo.html';
            $words["GNV - GOI&Aacute;S"] = 'http://www.zura.com.br/gnv-goias.html';
            $words["GNV - MATO GROSSO"] = 'http://www.zura.com.br/gnv-mato-grosso.html';
            $words["GNV - MATO GROSSO DO SUL"] = 'http://www.zura.com.br/gnv-mato-grosso-do-sul.html';
            $words["GNV - MINAS GERAIS"] = 'http://www.zura.com.br/gnv-minas-gerais.html';
            $words["GNV - PARA&Iacute;BA"] = 'http://www.zura.com.br/gnv-paraiba.html';
            $words["GNV - PARAN&Aacute;"] = 'http://www.zura.com.br/gnv-parana.html';
            $words["GNV - PERNAMBUCO"] = 'http://www.zura.com.br/gnv-pernambuco.html';
            $words["GNV - RIO DE JANEIRO"] = 'http://www.zura.com.br/gnv-rio-de-janeiro.html';
            $words["GNV - RIO GRANDE DO NORTE"] = 'http://www.zura.com.br/gnv-rio-grande-do-norte.html';
            $words["GNV - RIO GRANDE DO SUL"] = 'http://www.zura.com.br/gnv-rio-grande-do-sul.html';
            $words["GNV - SANTA CATARINA"] = 'http://www.zura.com.br/gnv-santa-catarina.html';
            $words["GNV - S&Atilde;O PAULO"] = 'http://www.zura.com.br/gnv-sao-paulo.html';
            $words["GNV - SERGIPE"] = 'http://www.zura.com.br/gnv-sergipe.html';
            $words["Golfe"] = 'http://www.zura.com.br/golfe.html';
            $words["Grampeador"] = 'http://www.zura.com.br/grampeador.html';
            $words["Gravador De DVD"] = 'http://www.zura.com.br/gravador-de-dvd.html';
            $words["Gravador Port&aacute;til"] = 'http://www.zura.com.br/gravador-portatil.html';
            $words["Guarda Chuvas"] = 'http://www.zura.com.br/guarda-chuvas.html';
            $words["Guerra - Aluguel"] = 'http://www.zura.com.br/guerra-aluguel.html';
            $words["Hard Disk (HD's)"] = 'http://www.zura.com.br/hard-disk-hd-s.html';
            $words["Hidratantes"] = 'http://www.zura.com.br/hidratantes.html';
            $words["Higiene Bucal"] = 'http://www.zura.com.br/higiene-bucal.html';
            $words["Higiene Para Beb&ecirc;"] = 'http://www.zura.com.br/higiene-para-bebe.html';
            $words["Higiene Pessoal"] = 'http://www.zura.com.br/higiene-pessoal.html';
            $words["Higienizador A Vapor"] = 'http://www.zura.com.br/higienizador-a-vapor.html';
            $words["Hist&oacute;ria - Aluguel"] = 'http://www.zura.com.br/historia-aluguel.html';
            $words["Horti-fruti"] = 'http://www.zura.com.br/horti-fruti.html';
            $words["Hot&eacute;is - Alagoas"] = 'http://www.zura.com.br/hoteis-al.html';
            $words["Hot&eacute;is - Manus"] = 'http://www.zura.com.br/hoteis-am.html';
            $words["Hot&eacute;is - Bahia"] = 'http://www.zura.com.br/hoteis-ba.html';
            $words["Hot&eacute;is - Ceara"] = 'http://www.zura.com.br/hoteis-ce.html';
            $words["Hot&eacute;is - Brasilia"] = 'http://www.zura.com.br/hoteis-df.html';
            $words["Hot&eacute;is - Espirito Santo"] = 'http://www.zura.com.br/hoteis-es.html';
            $words["Hot&eacute;is - Goias"] = 'http://www.zura.com.br/hoteis-go.html';
            $words["Hot&eacute;is - Maranh&atilde;o"] = 'http://www.zura.com.br/hoteis-ma.html';
            $words["Hot&eacute;is - Minas Gerais"] = 'http://www.zura.com.br/hoteis-mg.html';
            $words["Hot&eacute;is - MS"] = 'http://www.zura.com.br/hoteis-ms.html';
            $words["Hot&eacute;is - Mato Grosso"] = 'http://www.zura.com.br/hoteis-mt.html';
            $words["Hot&eacute;is - Par&aacute;"] = 'http://www.zura.com.br/hoteis-pa.html';
            $words["Hot&eacute;is - Para&iacute;ba"] = 'http://www.zura.com.br/hoteis-pb.html';
            $words["Hot&eacute;is - Pernambuco"] = 'http://www.zura.com.br/hoteis-pe.html';
            $words["Hot&eacute;is - Piau&iacute;"] = 'http://www.zura.com.br/hoteis-pi.html';
            $words["Hot&eacute;is - Paran&aacute;"] = 'http://www.zura.com.br/hoteis-pr.html';
            $words["Hot&eacute;is - Rio De Janeiro"] = 'http://www.zura.com.br/hoteis-rj.html';
            $words["Hot&eacute;is - Rio Grande Do Norte"] = 'http://www.zura.com.br/hoteis-rn.html';
            $words["Hot&eacute;is - Rio Grande Do Sul"] = 'http://www.zura.com.br/hoteis-rs.html';
            $words["Hot&eacute;is - Santa Catarina"] = 'http://www.zura.com.br/hoteis-sc.html';
            $words["Hot&eacute;is - Sergipe"] = 'http://www.zura.com.br/hoteis-se.html';
            $words["Hot&eacute;is - S&atilde;o Paulo"] = 'http://www.zura.com.br/hoteis-sp.html';
            $words["Hub"] = 'http://www.zura.com.br/hub.html';
            $words["Ilumina&ccedil;&atilde;o E Lumin&aacute;rias"] = 'http://www.zura.com.br/iluminacao-luminarias.html';
            $words["Iluminador"] = 'http://www.zura.com.br/iluminador.html';
            $words["Im&oacute;veis"] = 'http://www.zura.com.br/imoveis.html';
            $words["Impressora E Multifuncional"] = 'http://www.zura.com.br/impressora-multifuncional.html';
            $words["Multifuncional"] = 'http://www.zura.com.br/impressora-multifuncional.html';
            $words["Inalador E Nebulizador"] = 'http://www.zura.com.br/inalador-nebulizador.html';
            $words["Infantil - Aluguel"] = 'http://www.zura.com.br/infantil-aluguel.html';
            $words["Infl&aacute;veis"] = 'http://www.zura.com.br/inflaveis.html';
            $words["Instrumento De Medi&ccedil;&atilde;o"] = 'http://www.zura.com.br/instrumento-de-medicao.html';
            $words["Instrumentos De Corda"] = 'http://www.zura.com.br/instrumentos-de-corda.html';
            $words["Instrumentos De Percuss&atilde;o"] = 'http://www.zura.com.br/instrumentos-de-percussao.html';
            $words["Instrumentos De Sopro"] = 'http://www.zura.com.br/instrumentos-de-sopro.html';
            $words["Instrumentos De Teclado"] = 'http://www.zura.com.br/instrumentos-de-teclado.html';
            $words["Jardinagem"] = 'http://www.zura.com.br/jardinagem.html';
            $words["Jogos De Cama Avulsos"] = 'http://www.zura.com.br/jogos-de-cama-avulsos.html';
            $words["Jogos De Cama Completos"] = 'http://www.zura.com.br/jogos-de-cama-completos.html';
            $words["Jogos De Cama Para Beb&ecirc;s"] = 'http://www.zura.com.br/jogos-de-cama-para-bebes.html';
            $words["Jogos Diversos"] = 'http://www.zura.com.br/jogos-diversos.html';
            $words["Jogos Dreamcast"] = 'http://www.zura.com.br/jogos-dreamcast.html';
            $words["Jogos Educativos"] = 'http://www.zura.com.br/jogos-educativos.html';
            $words["Jogos Game Cube"] = 'http://www.zura.com.br/jogos-game-cube.html';
            $words["Jogos GameBoy"] = 'http://www.zura.com.br/jogos-gameboy.html';
            $words["Jogos Nintendo DS"] = 'http://www.zura.com.br/jogos-nintendo-ds.html';
            $words["Jogos Para Computador (PC)"] = 'http://www.zura.com.br/jogos-para-computador-pc.html';
            $words["Jogos PS1"] = 'http://www.zura.com.br/jogos-ps1.html';
            $words["Jogos PS2"] = 'http://www.zura.com.br/jogos-ps2.html';
            $words["Jogos PS3"] = 'http://www.zura.com.br/jogos-ps3.html';
            $words["Jogos PSP"] = 'http://www.zura.com.br/jogos-psp.html';
            $words["Jogos Wii"] = 'http://www.zura.com.br/jogos-wii.html';
            $words["Jogos Xbox"] = 'http://www.zura.com.br/jogos-xbox.html';
            $words["Jogos Xbox 360"] = 'http://www.zura.com.br/jogos-xbox-360.html';
            $words["J&oacute;ias"] = 'http://www.zura.com.br/joias.html';
            $words["J&oacute;ias Religiosas"] = 'http://www.zura.com.br/joias-religiosas.html';
            $words["Jornalismo - Aluguel"] = 'http://www.zura.com.br/jornalismo-aluguel.html';
            $words["Joystick"] = 'http://www.zura.com.br/joystick.html';
            $words["Kit E Estojo Para Maquiagem"] = 'http://www.zura.com.br/kit-estojo-para-maquiagem.html';
            $words["Kits E Acess&oacute;rios"] = 'http://www.zura.com.br/kits-acessorios.html';
            $words["Kits Er&oacute;ticos"] = 'http://www.zura.com.br/kits-eroticos.html';
            $words["Lancheira"] = 'http://www.zura.com.br/lancheira.html';
            $words["L&aacute;pis De Cor"] = 'http://www.zura.com.br/lapis-de-cor.html';
            $words["L&aacute;pis E Lapiseira"] = 'http://www.zura.com.br/lapis-lapiseira.html';
            $words["Latic&iacute;nios"] = 'http://www.zura.com.br/laticinios.html';
            $words["Lava-Lou&ccedil;as"] = 'http://www.zura.com.br/lava-loucas.html';
            $words["Leitor De Cart&atilde;o Para Computador"] = 'http://www.zura.com.br/leitor-de-cartao-para-computador.html';
            $words["Leitores De Cart&otilde;es"] = 'http://www.zura.com.br/leitores-de-cartoes.html';
            $words["Len&ccedil;ol"] = 'http://www.zura.com.br/lencol.html';
            $words["Lentes E Filtros"] = 'http://www.zura.com.br/lentes-filtros.html';
            $words["Licores"] = 'http://www.zura.com.br/licores.html';
            $words["Liquidificador"] = 'http://www.zura.com.br/liquidificador.html';
            $words["Lixadeira , Plainas E Politriz"] = 'http://www.zura.com.br/lixadeira-plainas-politriz.html';
            $words["Lixeiras E Cestos De Lixo"] = 'http://www.zura.com.br/lixeiras-cestos-de-lixo.html';
            $words["Lubrificantes / Cosm&eacute;ticos"] = 'http://www.zura.com.br/lubrificantes-cosmeticos.html';
            $words["Mamadeira"] = 'http://www.zura.com.br/mamadeira.html';
            $words["Manta"] = 'http://www.zura.com.br/manta.html';
            $words["Manuten&ccedil;&atilde;o Para PC"] = 'http://www.zura.com.br/manutencao-para-pc.html';
            $words["M&atilde;os E P&eacute;s"] = 'http://www.zura.com.br/maos-pes.html';
            $words["Maquiagem"] = 'http://www.zura.com.br/maquiagem.html';
            $words["M&aacute;quina De Automa&ccedil;&atilde;o"] = 'http://www.zura.com.br/maquina-de-automacao.html';
            $words["M&aacute;quina De Costura"] = 'http://www.zura.com.br/maquina-de-costura.html';
            $words["M&aacute;quina De Gelo "] = 'http://www.zura.com.br/maquina-de-gelo.html';
            $words["M&aacute;quina De Lavar Roupa"] = 'http://www.zura.com.br/maquina-de-lavar-roupa.html';
            $words["M&aacute;quina De Torta"] = 'http://www.zura.com.br/maquina-de-torta.html';
            $words["M&aacute;quinas Para Escrit&oacute;rio"] = 'http://www.zura.com.br/maquinas-para-escritorio.html';
            $words["Mascote"] = 'http://www.zura.com.br/mascote.html';
            $words["Massa De Modelar"] = 'http://www.zura.com.br/massa-de-modelar.html';
            $words["Massageador"] = 'http://www.zura.com.br/massageador.html';
            $words["Massageadores"] = 'http://www.zura.com.br/massageadores.html';
            $words["Materiais  Hospitalares E Laboratoriais"] = 'http://www.zura.com.br/materiais-hospitalares-laboratoriais.html';
            $words["Materiais El&eacute;tricos"] = 'http://www.zura.com.br/materiais-eletricos.html';
            $words["Material Gr&aacute;fico Personalizado"] = 'http://www.zura.com.br/material-grafico-personalizado.html';
            $words["Material Promocional"] = 'http://www.zura.com.br/material-promocional.html';
            $words["Medicamentos"] = 'http://www.zura.com.br/medicamentos.html';
            $words["Medidor De Glicose E Acess&oacute;rio"] = 'http://www.zura.com.br/medidor-de-glicose-acessorio.html';
            $words["Meias"] = 'http://www.zura.com.br/meias.html';
            $words["Mem&oacute;ria RAM"] = 'http://www.zura.com.br/memoria-ram.html';
            $words["Mercearia"] = 'http://www.zura.com.br/mercearia.html';
            $words["Mergulho / Ca&ccedil;a Submarina"] = 'http://www.zura.com.br/mergulho-caca-submarina.html';
            $words["Mesa"] = 'http://www.zura.com.br/mesa.html';
            $words["Mesa Digitalizadora"] = 'http://www.zura.com.br/mesa-digitalizadora.html';
            $words["Micro E Mini-System"] = 'http://www.zura.com.br/micro-mini-system.html';
            $words["Microfone"] = 'http://www.zura.com.br/microfone.html';
            $words["Midia Virgem E Acess&oacute;rios"] = 'http://www.zura.com.br/midia-virgem-acessorios.html';
            $words["Mini Moto"] = 'http://www.zura.com.br/mini-moto.html';
            $words["M&oacute;biles"] = 'http://www.zura.com.br/mobiles.html';
            $words["Mochila Esportiva"] = 'http://www.zura.com.br/mochila-esportiva.html';
            $words["Mochila/Maleta Para Notebook"] = 'http://www.zura.com.br/mochila-maleta-para-notebook.html';
            $words["Mochilas E Bolsas Escolares"] = 'http://www.zura.com.br/mochilas-bolsas-escolares.html';
            $words["Moda Praia Feminina"] = 'http://www.zura.com.br/moda-praia-feminina.html';
            $words["Modem"] = 'http://www.zura.com.br/modem.html';
            $words["M&oacute;dulos De Pot&ecirc;ncia E Amplificadores"] = 'http://www.zura.com.br/modulos-de-potencia-amplificadores.html';
            $words["Molhos E Temperos"] = 'http://www.zura.com.br/molhos-temperos.html';
            $words["Monitor Card&iacute;aco"] = 'http://www.zura.com.br/monitor-cardiaco.html';
            $words["Mordedores"] = 'http://www.zura.com.br/mordedores.html';
            $words["Mosquiteiro"] = 'http://www.zura.com.br/mosquiteiro.html';
            $words["Moto Nova"] = 'http://www.zura.com.br/moto-nova.html';
            $words["Moto Usada"] = 'http://www.zura.com.br/moto-usada.html';
            $words["Moto-pe&ccedil;as"] = 'http://www.zura.com.br/moto-pecas.html';
            $words["Mouse Pad E Apoios"] = 'http://www.zura.com.br/mouse-pad-apoios.html';
            $words["Mouses"] = 'http://www.zura.com.br/mouses.html';
            $words["M&oacute;veis Para Beb&ecirc;"] = 'http://www.zura.com.br/moveis-para-bebe.html';
            $words["M&oacute;veis Para Escrit&oacute;rio"] = 'http://www.zura.com.br/moveis-para-escritorio.html';
            $words["Mov&eacute;is Para O Com&eacute;rcio"] = 'http://www.zura.com.br/moveis-para-o-comercio.html';
            $words["MP3 Player"] = 'http://www.zura.com.br/mp3-player.html';
            $words["MP5 Player"] = 'http://www.zura.com.br/mp5-player.html';
            $words["Multiprocessador De Alimentos"] = 'http://www.zura.com.br/multiprocessador-de-alimentos.html';
            $words["Musical - Aluguel"] = 'http://www.zura.com.br/musical-aluguel.html';
            $words["Nacional - Aluguel"] = 'http://www.zura.com.br/nacional-aluguel.html';
            $words["Nata&ccedil;&atilde;o / Hidrogin&aacute;stica"] = 'http://www.zura.com.br/natacao-hidroginastica.html';
            $words["Natureza - Aluguel"] = 'http://www.zura.com.br/natureza-aluguel.html';
            $words["&Oacute;culos Escuros"] = 'http://www.zura.com.br/oculos-escuros.html';
            $words["&Oacute;leo Para Motor"] = 'http://www.zura.com.br/oleo-para-motor.html';
            $words["&Oacute;leos Corporais"] = 'http://www.zura.com.br/oleos-corporais.html';
            $words["Omeleteira"] = 'http://www.zura.com.br/omeleteira.html';
            $words["Organizador"] = 'http://www.zura.com.br/organizador.html';
            $words["Outras Ferramentas"] = 'http://www.zura.com.br/outras-ferramentas.html';
            $words["Outros Acess&oacute;rios De &Aacute;udio E V&iacute;deo"] = 'http://www.zura.com.br/outros-acessorios-de-audio-video.html';
            $words["Outros Acess&oacute;rios Para Maquiagem"] = 'http://www.zura.com.br/outros-acessorios-para-maquiagem.html';
            $words["Outros Alimentos"] = 'http://www.zura.com.br/outros-alimentos.html';
            $words["Outros &Aacute;udio E V&iacute;deo  "] = 'http://www.zura.com.br/outros-audio-video.html';
            $words["Outros Aviamentos"] = 'http://www.zura.com.br/outros-aviamentos.html';
            $words["Outros Beb&ecirc;s"] = 'http://www.zura.com.br/outros-bebes.html';
            $words["Outros Bebidas"] = 'http://www.zura.com.br/outros-bebidas.html';
            $words["Outros Beleza"] = 'http://www.zura.com.br/outros-beleza.html';
            $words["Outros Brinquedos E Jogos"] = 'http://www.zura.com.br/outros-brinquedos-jogos.html';
            $words["Outros Cama, Mesa E Banho"] = 'http://www.zura.com.br/outros-cama-mesa-banho.html';
            $words["Outros Carros E Motos"] = 'http://www.zura.com.br/outros-carros-motos.html';
            $words["Outros Casa E Jardim"] = 'http://www.zura.com.br/outros-casa-jardim.html';
            $words["Outros Cine E Foto"] = 'http://www.zura.com.br/outros-cine-foto.html';
            $words["Outros Cozinha"] = 'http://www.zura.com.br/outros-cozinha.html';
            $words["Outros Cursos"] = 'http://www.zura.com.br/outros-cursos.html';
            $words["Outros De Decora&ccedil;&atilde;o"] = 'http://www.zura.com.br/outros-de-decoracao.html';
            $words["Outros Eletrodom&eacute;sticos"] = 'http://www.zura.com.br/outros-eletrodomesticos.html';
            $words["Outros Esporte E Lazer"] = 'http://www.zura.com.br/outros-esporte-lazer.html';
            $words["Outros Jogos"] = 'http://www.zura.com.br/outros-jogos.html';
            $words["Outros Materiais De Constru&ccedil;&atilde;o"] = 'http://www.zura.com.br/outros-materiais-de-construcao.html';
            $words["Outros Moveis E Acess&oacute;rios"] = 'http://www.zura.com.br/outros-moveis-acessorios.html';
            $words["Outros Papelaria E Escrit&oacute;rio"] = 'http://www.zura.com.br/outros-papelaria-escritorio.html';
            $words["Outros Perif&eacute;ricos E Acess&oacute;rios"] = 'http://www.zura.com.br/outros-perifericos-acessorios.html';
            $words["Outros Pet Shop"] = 'http://www.zura.com.br/outros-pet-shop.html';
            $words["Outros Presentes Finos"] = 'http://www.zura.com.br/outros-presentes-finos.html';
            $words["Outros Redes"] = 'http://www.zura.com.br/outros-redes.html';
            $words["Outros Roupas, Cal&ccedil;ados E Acess&oacute;rios"] = 'http://www.zura.com.br/outros-roupas-calcados-acessorios.html';
            $words["Outros Sa&uacute;de"] = 'http://www.zura.com.br/outros-saude.html';
            $words["Outros Sex Shop"] = 'http://www.zura.com.br/outros-sex-shop.html';
            $words["Outros Ve&iacute;culos"] = 'http://www.zura.com.br/outros-veiculos.html';
            $words["Outros VHS"] = 'http://www.zura.com.br/outros-vhs.html';
            $words["Ovos De P&aacute;scoa"] = 'http://www.zura.com.br/ovos-de-pascoa.html';
            $words["Palmtop E PDA"] = 'http://www.zura.com.br/palmtop-pda.html';
            $words["Panelas, Assadeiras E Formas"] = 'http://www.zura.com.br/panelas-assadeiras-formas.html';
            $words["Pantufas"] = 'http://www.zura.com.br/pantufas.html';
            $words["Papel E Transpar&ecirc;ncia"] = 'http://www.zura.com.br/papel-transparencia.html';
            $words["Papelaria Em Geral"] = 'http://www.zura.com.br/papelaria-em-geral.html';
            $words["Para A Mam&atilde;e"] = 'http://www.zura.com.br/para-a-mamae.html';
            $words["Para Cabelos"] = 'http://www.zura.com.br/para-cabelos.html';
            $words["Parafusadeira"] = 'http://www.zura.com.br/parafusadeira.html';
            $words["Pasta"] = 'http://www.zura.com.br/pasta.html';
            $words["Patins"] = 'http://www.zura.com.br/patins.html';
            $words["Patins &amp; Acess&oacute;rios"] = 'http://www.zura.com.br/patins-acessorios.html';
            $words["Pedestais"] = 'http://www.zura.com.br/pedestais.html';
            $words["Ped&ocirc;metro"] = 'http://www.zura.com.br/pedometro.html';
            $words["P&ecirc;nis / Vibradores"] = 'http://www.zura.com.br/penis-vibradores.html';
            $words["Perfumes Femininos"] = 'http://www.zura.com.br/perfumes-femininos.html';
            $words["Perfumes Masculinos"] = 'http://www.zura.com.br/perfumes-masculinos.html';
            $words["Perfumes Unissex"] = 'http://www.zura.com.br/perfumes-unissex.html';
            $words["Perfuradores E Cortantes"] = 'http://www.zura.com.br/perfuradores-cortantes.html';
            $words["Persianas"] = 'http://www.zura.com.br/persianas.html';
            $words["Pesca"] = 'http://www.zura.com.br/pesca.html';
            $words["Piercing"] = 'http://www.zura.com.br/piercing.html';
            $words["Pin&ccedil;a"] = 'http://www.zura.com.br/pinca.html';
            $words["Pinc&eacute;is"] = 'http://www.zura.com.br/pinceis.html';
            $words["Pinc&eacute;is Para Maquiagem"] = 'http://www.zura.com.br/pinceis-para-maquiagem.html';
            $words["Ping-Pong, Pebolim (Tot&oacute;)"] = 'http://www.zura.com.br/ping-pong-pebolim-toto.html';
            $words["Piscina"] = 'http://www.zura.com.br/piscina.html';
            $words["Pisos E Revestimentos"] = 'http://www.zura.com.br/pisos-revestimentos.html';
            $words["Placa De Rede"] = 'http://www.zura.com.br/placa-de-rede.html';
            $words["Placas De Captura De V&iacute;deo"] = 'http://www.zura.com.br/placas-de-captura-de-video.html';
            $words["Placas De Som"] = 'http://www.zura.com.br/placas-de-som.html';
            $words["Placas De V&iacute;deo"] = 'http://www.zura.com.br/placas-de-video.html';
            $words["Placas-M&atilde;e"] = 'http://www.zura.com.br/placas-mae.html';
            $words["Placas-USB"] = 'http://www.zura.com.br/placas-usb.html';
            $words["Plastificadora"] = 'http://www.zura.com.br/plastificadora.html';
            $words["Playground"] = 'http://www.zura.com.br/playground.html';
            $words["Plug Er&oacute;tico"] = 'http://www.zura.com.br/plug-erotico.html';
            $words["Pneus"] = 'http://www.zura.com.br/pneus.html';
            $words["P&oacute; Compacto"] = 'http://www.zura.com.br/po-compacto.html';
            $words["Policial - Aluguel"] = 'http://www.zura.com.br/policial-aluguel.html';
            $words["Pompoarismo"] = 'http://www.zura.com.br/pompoarismo.html';
            $words["Porta Retrato Digital"] = 'http://www.zura.com.br/porta-retrato-digital.html';
            $words["Porta Retrato E &Aacute;lbum"] = 'http://www.zura.com.br/porta-retrato-album.html';
            $words["Portas E Janelas"] = 'http://www.zura.com.br/portas-janelas.html';
            $words["Poster"] = 'http://www.zura.com.br/poster.html';
            $words["Potes, Vasilhas E Recipientes"] = 'http://www.zura.com.br/potes-vasilhas-recipientes.html';
            $words["Pousadas - BA"] = 'http://www.zura.com.br/pousadas-ba.html';
            $words["Pousadas - CE"] = 'http://www.zura.com.br/pousadas-ce.html';
            $words["Pousadas - MA"] = 'http://www.zura.com.br/pousadas-ma.html';
            $words["Pousadas - MG"] = 'http://www.zura.com.br/pousadas-mg.html';
            $words["Pousadas - PE"] = 'http://www.zura.com.br/pousadas-pe.html';
            $words["Pousadas - RJ"] = 'http://www.zura.com.br/pousadas-rj.html';
            $words["Pousadas - RN"] = 'http://www.zura.com.br/pousadas-rn.html';
            $words["Pousadas - RS"] = 'http://www.zura.com.br/pousadas-rs.html';
            $words["Pousadas - SC"] = 'http://www.zura.com.br/pousadas-sc.html';
            $words["Pousadas - SP"] = 'http://www.zura.com.br/pousadas-sp.html';
            $words["Praia E Piscina"] = 'http://www.zura.com.br/praia-piscina.html';
            $words["Pranchetas"] = 'http://www.zura.com.br/pranchetas.html';
            $words["Pratos"] = 'http://www.zura.com.br/pratos.html';
            $words["Pratos Para Beb&ecirc;s"] = 'http://www.zura.com.br/pratos-para-bebes.html';
            $words["Preservativos"] = 'http://www.zura.com.br/preservativos.html';
            $words["Produtos Diet&eacute;ticos"] = 'http://www.zura.com.br/produtos-dieteticos.html';
            $words["Projetor (Data Show)"] = 'http://www.zura.com.br/projetor-data-show.html';
            $words["Protetor E Bronzeador"] = 'http://www.zura.com.br/protetor-bronzeador.html';
            $words["Protetores"] = 'http://www.zura.com.br/protetores.html';
            $words["Protetores De Rede"] = 'http://www.zura.com.br/protetores-de-rede.html';
            $words["Purificador De &Aacute;gua"] = 'http://www.zura.com.br/purificador-de-agua.html';
            $words["Quebra-cabe&ccedil;a"] = 'http://www.zura.com.br/quebra-cabeca.html';
            $words["Racks"] = 'http://www.zura.com.br/racks.html';
            $words["Raclete"] = 'http://www.zura.com.br/raclete.html';
            $words["R&aacute;dio Rel&oacute;gio"] = 'http://www.zura.com.br/radio-relogio.html';
            $words["R&aacute;dios"] = 'http://www.zura.com.br/radios.html';
            $words["Refrigerante"] = 'http://www.zura.com.br/refrigerante.html';
            $words["R&eacute;guas E Compassos"] = 'http://www.zura.com.br/reguas-compassos.html';
            $words["Religi&atilde;o - Aluguel"] = 'http://www.zura.com.br/religiao-aluguel.html';
            $words["Rel&oacute;gio De Parede"] = 'http://www.zura.com.br/relogio-de-parede.html';
            $words["Rel&oacute;gio De Pulso"] = 'http://www.zura.com.br/relogio-de-pulso.html';
            $words["Repelente"] = 'http://www.zura.com.br/repelente.html';
            $words["Repelente Eletr&ocirc;nico"] = 'http://www.zura.com.br/repelente-eletronico.html';
            $words["Resorts - BA"] = 'http://www.zura.com.br/resorts-ba.html';
            $words["Resorts - CE"] = 'http://www.zura.com.br/resorts-ce.html';
            $words["Resorts - PE"] = 'http://www.zura.com.br/resorts-pe.html';
            $words["Resorts - RJ"] = 'http://www.zura.com.br/resorts-rj.html';
            $words["Resorts - RN"] = 'http://www.zura.com.br/resorts-rn.html';
            $words["Retificadeira"] = 'http://www.zura.com.br/retificadeira.html';
            $words["Revista / Livros Er&oacute;ticos"] = 'http://www.zura.com.br/revista-livros-eroticos.html';
            $words["Revista De DVD's"] = 'http://www.zura.com.br/revista-de-dvd-s.html';
            $words["Revistas Avulsas"] = 'http://www.zura.com.br/revistas-avulsas.html';
            $words["Revistas E Jornais - Assinaturas"] = 'http://www.zura.com.br/revistas-jornais-assinaturas.html';
            $words["Revistas, Passatempos E Jornais"] = 'http://www.zura.com.br/revistas-passatempos-jornais.html';
            $words["R&iacute;mel E M&aacute;scara"] = 'http://www.zura.com.br/rimel-mascara.html';
            $words["Rodas"] = 'http://www.zura.com.br/rodas.html';
            $words["Romance - Aluguel"] = 'http://www.zura.com.br/romance-aluguel.html';
            $words["Rosto"] = 'http://www.zura.com.br/rosto.html';
            $words["Roteador"] = 'http://www.zura.com.br/roteador.html';
            $words["Roupa Feminina"] = 'http://www.zura.com.br/roupa-feminina.html';
            $words["Roupa Infantil"] = 'http://www.zura.com.br/roupa-infantil.html';
            $words["Roupa &Iacute;ntima Feminina"] = 'http://www.zura.com.br/roupa-intima-feminina.html';
            $words["Roupa &Iacute;ntima Infantil"] = 'http://www.zura.com.br/roupa-intima-infantil.html';
            $words["Roupa &Iacute;ntima Masculina"] = 'http://www.zura.com.br/roupa-intima-masculina.html';
            $words["Roupa &Iacute;ntima Para Gestante"] = 'http://www.zura.com.br/roupa-intima-para-gestante.html';
            $words["Roupa Masculina"] = 'http://www.zura.com.br/roupa-masculina.html';
            $words["Roupa Para Beb&ecirc;"] = 'http://www.zura.com.br/roupa-para-bebe.html';
            $words["Roup&atilde;o"] = 'http://www.zura.com.br/roupao.html';
            $words["Roupas &iacute;ntimas / Fantasias Er&oacute;ticas"] = 'http://www.zura.com.br/roupas-intimas-fantasias-eroticas.html';
            $words["Sabonete"] = 'http://www.zura.com.br/sabonete.html';
            $words["Sado Maso"] = 'http://www.zura.com.br/sado-maso.html';
            $words["Saia Para Cama"] = 'http://www.zura.com.br/saia-para-cama.html';
            $words["Sais De Banho"] = 'http://www.zura.com.br/sais-de-banho.html';
            $words["Salgadinho E Petiscos"] = 'http://www.zura.com.br/salgadinho-petiscos.html';
            $words["Sanduicheira E Grill"] = 'http://www.zura.com.br/sanduicheira-grill.html';
            $words["Secador, Chapinha E Prancha"] = 'http://www.zura.com.br/secador-chapinha-prancha.html';
            $words["Secadora De Roupa E Centr&iacute;fuga"] = 'http://www.zura.com.br/secadora-de-roupa-centrifuga.html';
            $words["Seguran&ccedil;a Automotiva"] = 'http://www.zura.com.br/seguranca-automotiva.html';
            $words["Seguran&ccedil;a Do Beb&ecirc;"] = 'http://www.zura.com.br/seguranca-do-bebe.html';
            $words["Seguran&ccedil;a Do Trabalho"] = 'http://www.zura.com.br/seguranca-do-trabalho.html';
            $words["Seguran&ccedil;a Domiciliar"] = 'http://www.zura.com.br/seguranca-domiciliar.html';
            $words["Seguran&ccedil;a Para Moto"] = 'http://www.zura.com.br/seguranca-para-moto.html';
            $words["Sementes"] = 'http://www.zura.com.br/sementes.html';
            $words["Serra El&eacute;trica"] = 'http://www.zura.com.br/serra-eletrica.html';
            $words["Servidor De Impress&atilde;o"] = 'http://www.zura.com.br/servidor-de-impressao.html';
            $words["Servidores"] = 'http://www.zura.com.br/servidores.html';
            $words["Shampoo"] = 'http://www.zura.com.br/shampoo.html';
            $words["Show Ou Musical"] = 'http://www.zura.com.br/show-ou-musical.html';
            $words["Shows E Concertos - Aluguel"] = 'http://www.zura.com.br/shows-concertos-aluguel.html';
            $words["Simulador De Caminhada"] = 'http://www.zura.com.br/simulador-de-caminhada.html';
            $words["Sinaliza&ccedil;&atilde;o"] = 'http://www.zura.com.br/sinalizacao.html';
            $words["Sistema Operacional"] = 'http://www.zura.com.br/sistema-operacional.html';
            $words["Skate"] = 'http://www.zura.com.br/skate.html';
            $words["Sobrenatural - Aluguel"] = 'http://www.zura.com.br/sobrenatural-aluguel.html';
            $words["Sof&aacute;"] = 'http://www.zura.com.br/sofa.html';
            $words["Som Automotivo"] = 'http://www.zura.com.br/som-automotivo.html';
            $words["Som Port&aacute;til"] = 'http://www.zura.com.br/som-portatil.html';
            $words["Sombra"] = 'http://www.zura.com.br/sombra.html';
            $words["Suplementos Nutricionais / Esportivos"] = 'http://www.zura.com.br/suplementos-nutricionais-esportivos.html';
            $words["Suporte Para Caixas Ac&uacute;sticas"] = 'http://www.zura.com.br/suporte-para-caixas-acusticas.html';
            $words["Suporte Para TV/V&iacute;deo"] = 'http://www.zura.com.br/suporte-para-tv-video.html';
            $words["Suportes"] = 'http://www.zura.com.br/suportes.html';
            $words["Suportes Para Notebook"] = 'http://www.zura.com.br/suportes-para-notebook.html';
            $words["Suprimentos De Escrit&oacute;rio"] = 'http://www.zura.com.br/suprimentos-de-escritorio.html';
            $words["Surfe - Aluguel"] = 'http://www.zura.com.br/surfe-aluguel.html';
            $words["Surfe / Bodyboard"] = 'http://www.zura.com.br/surfe-bodyboard.html';
            $words["Suspense - Aluguel"] = 'http://www.zura.com.br/suspense-aluguel.html';
            $words["Switch"] = 'http://www.zura.com.br/switch.html';
            $words["Tabacaria"] = 'http://www.zura.com.br/tabacaria.html';
            $words["Talco"] = 'http://www.zura.com.br/talco.html';
            $words["Talher Infantil"] = 'http://www.zura.com.br/talher-infantil.html';
            $words["Talheres E Faqueiros"] = 'http://www.zura.com.br/talheres-faqueiros.html';
            $words["Tapetes"] = 'http://www.zura.com.br/tapetes-carpete.html';
            $words["Tapetes E Carpete"] = 'http://www.zura.com.br/tapetes-carpete.html';
            $words["Tapetes, Cortinas E Persianas"] = 'http://www.zura.com.br/tapetes-cortinas-persianas.html';
            $words["Teclados"] = 'http://www.zura.com.br/teclados.html';
            $words["Telefone"] = 'http://www.zura.com.br/telefone.html';
            $words["Telefone Sem Fio"] = 'http://www.zura.com.br/telefone-sem-fio.html';
            $words["Telefonia IP / VOIP"] = 'http://www.zura.com.br/telefonia-ip-voip.html';
            $words["T&ecirc;nis / Squash"] = 'http://www.zura.com.br/tenis-squash.html';
            $words["T&ecirc;nis Infantil "] = 'http://www.zura.com.br/tenis-infantil.html';
            $words["Tequila"] = 'http://www.zura.com.br/tequila.html';
            $words["Term&ocirc;metro"] = 'http://www.zura.com.br/termometro.html';
            $words["Terror - Aluguel"] = 'http://www.zura.com.br/terror-aluguel.html';
            $words["Tesouras"] = 'http://www.zura.com.br/tesouras.html';
            $words["Tinta Para Toner / Cartucho"] = 'http://www.zura.com.br/tinta-para-toner-cartucho.html';
            $words["Tintas, Solventes E Vernizes"] = 'http://www.zura.com.br/tintas-solventes-vernizes.html';
            $words["Tiro E Ca&ccedil;a"] = 'http://www.zura.com.br/tiro-caca.html';
            $words["Toalhas De Banho"] = 'http://www.zura.com.br/toalhas-de-banho.html';
            $words["Toalhas De Mesa"] = 'http://www.zura.com.br/toalhas-de-mesa.html';
            $words["Tradutor"] = 'http://www.zura.com.br/tradutor.html';
            $words["Tratamentos"] = 'http://www.zura.com.br/tratamentos.html';
            $words["Travesseiros"] = 'http://www.zura.com.br/travesseiros.html';
            $words["Trip&eacute;"] = 'http://www.zura.com.br/tripe.html';
            $words["Troninhos E Redutores"] = 'http://www.zura.com.br/troninhos-redutores.html';
            $words["Tunning Automotivo"] = 'http://www.zura.com.br/tunning-automotivo.html';
            $words["Tunning Para Motos"] = 'http://www.zura.com.br/tunning-para-motos.html';
            $words["TV - Miniss&eacute;rie - Aluguel"] = 'http://www.zura.com.br/tv-minisserie-aluguel.html';
            $words["TV - Programa - Aluguel"] = 'http://www.zura.com.br/tv-programa-aluguel.html';
            $words["TV - S&eacute;rie - Aluguel"] = 'http://www.zura.com.br/tv-serie-aluguel.html';
            $words["Unidade De Backup"] = 'http://www.zura.com.br/unidade-de-backup.html';
            $words["Uniformes"] = 'http://www.zura.com.br/uniformes.html';
            $words["Utens&iacute;lios De Limpeza"] = 'http://www.zura.com.br/utensilios-de-limpeza.html';
            $words["Utens&iacute;lios Diversos "] = 'http://www.zura.com.br/utensilios-diversos.html';
            $words["Utens&iacute;lios E Brinquedos Para Praia E Piscina"] = 'http://www.zura.com.br/utensilios-brinquedos-para-praia-piscina.html';
            $words["Utens&iacute;lios Para Ferramentas"] = 'http://www.zura.com.br/utensilios-para-ferramentas.html';
            $words["Utilidades"] = 'http://www.zura.com.br/utilidades.html';
            $words["Utilidades Dom&eacute;sticas"] = 'http://www.zura.com.br/utilidades-domesticas.html';
            $words["Vagina / Boca / &Acirc;nus"] = 'http://www.zura.com.br/vagina-boca-anus.html';
            $words["Ve&iacute;culo Motorizado"] = 'http://www.zura.com.br/veiculo-motorizado.html';
            $words["Ve&iacute;culos De Controle Remoto"] = 'http://www.zura.com.br/veiculos-de-controle-remoto.html';
            $words["Vestu&aacute;rio Esportivo"] = 'http://www.zura.com.br/vestuario-esportivo.html';
            $words["Video Cassete"] = 'http://www.zura.com.br/video-cassete.html';
            $words["Videok&ecirc; E Karaok&ecirc;"] = 'http://www.zura.com.br/videoke-karaoke.html';
            $words["Vinhos"] = 'http://www.zura.com.br/vinhos.html';
            $words["Vinil"] = 'http://www.zura.com.br/vinil.html';
            $words["Viol&ecirc;ncia - Aluguel"] = 'http://www.zura.com.br/violencia-aluguel.html';
            $words["Viseira Para Capacete"] = 'http://www.zura.com.br/viseira-para-capacete.html';
            $words["Vitaminas"] = 'http://www.zura.com.br/vitaminas.html';
            $words["Vodka"] = 'http://www.zura.com.br/vodka.html';
            $words["Voleibol E Futev&ocirc;lei"] = 'http://www.zura.com.br/voleibol-futevolei.html';
            $words["Walk-Talk, R&aacute;dios Comunicadores"] = 'http://www.zura.com.br/walk-talk-radios-comunicadores.html';
            $words["Walkman/ Discman"] = 'http://www.zura.com.br/walkman-discman.html';
            $words["WebCam"] = 'http://www.zura.com.br/webcam.html';
            $words["Western - Aluguel"] = 'http://www.zura.com.br/western-aluguel.html';
            $words["Whisky"] = 'http://www.zura.com.br/whisky.html';

            $atualiza_words = true;
    
        }
        
        zuraHotLinks::$words = $words;
        
        if($instalacao) {
        
            //Criar opções
            if(function_exists("add_blog_option")) {
                $string = zuraHotLinks::arrayToString($words);
                add_blog_option(zuraHotLinks::$blog_id,"zhl_words",$string);
                $string = zuraHotLinks::arrayToString($settings);
                add_blog_option(zuraHotLinks::$blog_id,"zhl_settings",$string);
            } else {
                $string = zuraHotLinks::arrayToString($words);
                add_option("zhl_words",$string);
                $string = zuraHotLinks::arrayToString($settings);
                add_option("zhl_settings",$string);
            }
            
        } else {
        
            if($atualiza_settings) {
                if(function_exists("update_blog_option")) {
                    $string = zuraHotLinks::arrayToString($settings);
                    update_blog_option(zuraHotLinks::$blog_id,"zhl_settings",$string);
                } else {
                    $string = zuraHotLinks::arrayToString($settings);
                    update_option("zhl_settings",$string);
                }
            }
            
            if($atualiza_words) {
                if(function_exists("update_blog_option")) {
                    $string = zuraHotLinks::arrayToString($words);
                    update_blog_option(zuraHotLinks::$blog_id,"zhl_words",$string);
                } else {
                    $string = zuraHotLinks::arrayToString($words);
                    update_option("zhl_words",$string);
                }
            }
		}
        
		//Definir ganchos
		add_filter("the_content", array("zuraHotLinks","geraHotLinks"));
		add_filter("the_excerpt", array("zuraHotLinks","geraHotLinks"));
		add_action('admin_menu', array('zuraHotLinks','adicionarMenu'));
		
	}
	
	/**
	 * Função de instalação, ao ativar o plugin esta função é chamada
	 *
	 */
	public static function ativar() {

        $words = array();
        
        $instalar = true;
        
        // inicializa o plugin inserindo as configurações no banco
		zuraHotLinks::inicializar($instalar);
		
	}
	
	/**
	 * Esta função remove tracos de uma instalação deste plugin, removendo
	 * as tabelas e dados da base de dados
	 *
	 */
	public static function desativar(){

		//Remover opções
        if(function_exists("update_blog_option")) {
            delete_blog_option(zuraHotLinks::$blog_id,"zhl_words");
        } else {
            delete_option("zhl_words");
        }
        
	}
	
	/**
	 * Esta função adiciona uma nova aba no menu do wordpress
	 * onde este plugin será configurado
	 *
	 */
	public static function adicionarMenu(){
		add_options_page('Zura HotLinks - Gerenciamento','Zura HotLinks',10,__FILE__,array("zuraHotLinks","abaOpcoes"));
	}
	
	/**
	 * Esta função mostra a aba de configuração do plugin e é responsável por
	 * gravar os dados configurados
	 *
	 */
	public static function abaOpcoes(){
		
		//Predefinidos
		$templateVars['{UPDATED}'] = "";
		$templateVars['{ERROS}'] = "";
		
		//Executar operações definidas
		if (count($_POST) > 0){
            if(!is_numeric($_POST["pr"])) {
                $pr = 0;
            } else {
                $pr = $_POST["pr"];
            }
        
            if(!$pr && is_numeric($_POST["site"]) && $_POST["site"] > 0) {
                $templateVars['{UPDATED}'] = '<div id="message" class="error"><p><strong>O campo PR &eacute; obrigat&oacute;rio!</strong></p></div>';
            } else {
                $settings = array (
                    "pr"		=> $pr,
                    "site"		=> $_POST["site"],
                    "blank"		=> $_POST["blank"],
                    "charset"   => $_POST["charset"],
                    "links"   => $_POST["links"],
                    );
                    
                if(function_exists("update_blog_option")) {
                    $string = zuraHotLinks::arrayToString($settings);
                    update_blog_option(zuraHotLinks::$blog_id,"zhl_settings",$string);
                } else {
                    $string = zuraHotLinks::arrayToString($settings);
                    update_option("zhl_settings",$string);
                }
                
                $templateVars['{UPDATED}'] = '<div id="message" class="updated fade"><p><strong>Dados atualizados!</strong></p></div>';
                
            }
		}
		
		
		//Ler arquivo de template usando funções do WP
        $admTpl = file_get_contents(zuraHotLinks::$info['plugin_fpath']."/admin_tpl.htm");
        
        if(function_exists("get_blog_option")) {
            $string = get_blog_option(zuraHotLinks::$blog_id,"zhl_settings");
            $settings = zuraHotLinks::stringToArray($string);
        } else {
            $string = get_option("zhl_settings");
            $settings = zuraHotLinks::stringToArray($string);
        }
        
        
        $templateVars['{PR}'] = $settings['pr'];
        $templateVars['{SITE}'] = $settings['site'];
        $templateVars['{BLANK}'] = ($settings['blank']) ? 'checked = "checked"' : '';
        $templateVars['{ISO-8859-1}'] = '';
        $templateVars['{ISO-8859-15}'] = '';
        $templateVars['{UTF-8}'] = '';
        $templateVars['{cp866}'] = '';
        $templateVars['{cp1251}'] = '';
        $templateVars['{cp1252}'] = '';
        $templateVars['{KOI8-R}'] = '';
        $templateVars['{BIG5}'] = '';
        $templateVars['{GB2312}'] = '';
        $templateVars['{BIG5-HKSCS}'] = '';
        $templateVars['{Shift_JIS}'] = '';
        $templateVars['{EUC-JP}'] = '';
        $templateVars['{'.$settings['charset'].'}'] = 'selected';
        for($i = 1; $i<=10; $i++) {
            $templateVars['{link-'.$i.'}'] = '';
        }
        $templateVars['{link-'.$settings['links'].'}'] = 'selected';
		
		//Substituir variáveis no template		
		$admTpl = strtr($admTpl,$templateVars);
		

		echo $admTpl;
		
	}
	
	/**
	 * Esta função busca no banco o par palavra/nova palavra
	 * e faz a substituição no texto do post
	 *
	 * @param string $post_texto Texto original do post
	 * @return string Texto com alterações feitas
	 */
	public static function geraHotLinks($post_texto) {
    
        // pega as palavras para serem traduzidas no banco
        if(function_exists("get_blog_option")) {
            $string = get_blog_option(zuraHotLinks::$blog_id,"zhl_settings");
            $settings = zuraHotLinks::stringToArray($string);
        } else {
            $string = get_option("zhl_settings");
            $settings = zuraHotLinks::stringToArray($string);
        }
        
        $words = zuraHotLinks::$words;
        
        $links = array();
        $i = 0;
        
        // retirar os links e repor depois
        $continua = true;
        while(strpos($post_texto,"<a")!==false && $continua) {
            $pos = strpos($post_texto,"<a");
            if(strpos( $post_texto, "</a>" )>$pos) {
                $parcial = substr( $post_texto, $pos,(strpos( $post_texto, "</a>" ) - strpos($post_texto,"<a") +4 ) );
                $links[$i] = $parcial;
                $post_texto = str_replace($parcial,"##ZURA##".$i."##ZURA##",$post_texto);
                $i++;
            } else {
                $continua = false;
            }
        }
        
        
        // retirar demais elementos HTML e repor depois
        $continua = true;
        while(strpos($post_texto,"<")!==false && $continua) {
            $pos = strpos($post_texto,"<");
            if(strpos( $post_texto, ">" )>$pos) {
                $parcial = substr( $post_texto, $pos,(strpos( $post_texto, ">" ) - strpos($post_texto,"<") +1 ) );
                $links[$i] = $parcial;
                $post_texto = str_replace($parcial,"##ZURA##".$i."##ZURA##",$post_texto);
                $i++;
            } else {
                $continua = false;
            }
        }
        
       
        // retirar elementos METATAG e repor depois
        $continua = true;
        while(strpos($post_texto,"[")!==false && $continua) {
            $pos = strpos($post_texto,"[");
            if(strpos( $post_texto, "]" )>$pos) {
                $parcial = substr( $post_texto, $pos,(strpos( $post_texto, "]" ) - strpos($post_texto,"[") +1 ) );
                $links[$i] = $parcial;
                $post_texto = str_replace($parcial,"##ZURA##".$i."##ZURA##",$post_texto);
                $i++;
            } else {
                $continua = false;
            }
        }
        
        
        $post_texto = htmlentities($post_texto, ENT_NOQUOTES, $settings['charset']);
        
        $palavras_encontradas = 0;
        $parar = false;
        
        
        foreach($words as $expressao => $substituicao) {
        
            if($substituicao != "") {
        
                if(!$parar) {
                
                    $achou = false;
                    
                    
                    // iniciar a busca por palavras com espaços em torno
                    $busca = ' '.$expressao.' ';
                    while(!$parar && !$achou && (stripos($post_texto,$busca)!==false) && ($palavras_encontradas <= $settings['links'])) {
                        $achou = true;
                        $posicao = stripos($post_texto,$busca);
                        $original = substr($post_texto,$posicao,strlen($busca)-1);
                        $titulo = substr($post_texto,$posicao,strlen($busca)-1);
                        $url = " <a href='".$substituicao;
                        if($settings['pr']) {
                            $url .= ((strpos($substituicao,'?')!==false)?'&':'?')."pr=".$settings['pr'];
                            if($settings['site']) $url .= "&site=".$settings['site'];
                        }
                        $url .= "' title='".$titulo."' ";
                        if($settings['blank']) $url .= "target='_blank'";
                        $url .= ">".$original."</a> ";
                        $links[$i] = $url;
                        $post_texto = substr($post_texto,0,$posicao)."##ZURA##".$i."##ZURA##".substr($post_texto,$posicao+strlen($busca),strlen($post_texto)-($posicao+strlen($busca)));
                        $palavras_encontradas++;
                        if($palavras_encontradas >= $settings['links']) $parar = true;
                        $i++;
                    }
                    if(!$parar && $palavras_encontradas >= $settings['links']) $parar = true;
                    
                    // iniciar a busca por palavras com vírgula atrás
                    $busca = ' '.$expressao.', ';
                    while((!$parar && !$achou && stripos($post_texto,$busca)!==false) && ($palavras_encontradas <= $settings['links'])) {
                        $achou = true;
                        $posicao = stripos($post_texto,$busca);
                        $original = substr($post_texto,$posicao,strlen($busca)-1);
                        $titulo = substr($post_texto,$posicao,strlen($busca)-2);
                        $url = " <a href='".$substituicao;
                        if($settings['pr']) {
                            $url .= ((strpos($substituicao,'?')!==false)?'&':'?')."pr=".$settings['pr'];
                            if($settings['site']) $url .= "&site=".$settings['site'];
                        }
                        $url .= "' title='".$titulo."' ";
                        if($settings['blank']) $url .= "target='_blank'";
                        $url .= ">".$original."</a> ";
                        $links[$i] = $url;
                        $post_texto = substr($post_texto,0,$posicao)."##ZURA##".$i."##ZURA##".substr($post_texto,$posicao+strlen($busca),strlen($post_texto)-($posicao+strlen($busca)));
                        $palavras_encontradas++;
                        if($palavras_encontradas >= $settings['links']) $parar = true;
                        $i++;
                    }
                    if(!$parar && $palavras_encontradas >= $settings['links']) $parar = true;
                    
                    // iniciar a busca por palavras com ponto atrás
                    $busca = ' '.$expressao.'. ';
                    while(!$parar && !$achou && (stripos($post_texto,$busca)!==false) && ($palavras_encontradas <= $settings['links'])) {
                        $achou = true;
                        $posicao = stripos($post_texto,$busca);
                        $original = substr($post_texto,$posicao,strlen($busca)-1);
                        $titulo = substr($post_texto,$posicao,strlen($busca)-2);
                        $url = " <a href='".$substituicao;
                        if($settings['pr']) {
                            $url .= ((strpos($substituicao,'?')!==false)?'&':'?')."pr=".$settings['pr'];
                            if($settings['site']) $url .= "&site=".$settings['site'];
                        }
                        $url .= "' title='".$titulo."' ";
                        if($settings['blank']) $url .= "target='_blank'";
                        $url .= ">".$original."</a> ";
                        $links[$i] = $url;
                        $post_texto = substr($post_texto,0,$posicao)."##ZURA##".$i."##ZURA##".substr($post_texto,$posicao+strlen($busca),strlen($post_texto)-($posicao+strlen($busca)));
                        $palavras_encontradas++;
                        if($palavras_encontradas >= $settings['links']) $parar = true;
                        $i++;
                    }
                    if(!$parar && $palavras_encontradas >= $settings['links']) $parar = true;
                    
                    // iniciar a busca por palavras com ponto atrás
                    $busca = ' '.$expressao.'#';
                    while(!$parar && !$achou && (stripos($post_texto,$busca)!==false) && ($palavras_encontradas <= $settings['links'])) {
                        $achou = true;
                        $posicao = stripos($post_texto,$busca);
                        $original = substr($post_texto,$posicao,strlen($busca)-1);
                        $titulo = substr($post_texto,$posicao,strlen($busca)-1);
                        $url = " <a href='".$substituicao;
                        if($settings['pr']) {
                            $url .= ((strpos($substituicao,'?')!==false)?'&':'?')."pr=".$settings['pr'];
                            if($settings['site']) $url .= "&site=".$settings['site'];
                        }
                        $url .= "' title='".$titulo."' ";
                        if($settings['blank']) $url .= "target='_blank'";
                        $url .= ">".$original."</a> ";
                        $links[$i] = $url;
                        $post_texto = substr($post_texto,0,$posicao)."##ZURA##".$i."##ZURA##".substr($post_texto,$posicao+strlen($busca)-1,strlen($post_texto)-($posicao+strlen($busca)-1));
                        $palavras_encontradas++;
                        if($palavras_encontradas >= $settings['links']) $parar = true;
                        $i++;
                    }
                    if(!$parar && $palavras_encontradas >= $settings['links']) $parar = true;
                    
                } else {
                    break;
                }
                
            }
            
        }
        
        // forçar a liberação da memória
        unset($words);
        
        $post_texto = html_entity_decode($post_texto, ENT_NOQUOTES, $settings['charset']);
        
        $encontrar = array();
        $substituir = array();

        // refazer o conteudo adicionando todos os links criados
        foreach($links as $key => $link) {
            $encontrar[] = "##ZURA##".$key."##ZURA##";
            $substituir[] = $link;
        }
        
        if(count($encontrar) >= 1) $post_texto = str_replace($encontrar,$substituir,$post_texto);
        
		return $post_texto;
        
	}
	
	/**
	 * Esta função converte um array para uma
	 * string pre-formatada. Isso é preciso pois o wordpress não 
     * faz a conversão automática na hora de devolver um array no 
     * get_option / get_blog_option
	 *
	 * @param string $arr array para ser armazenado
	 * @return string String codificada para armazenamento
	 */
	public static function arrayToString($arr = 0) {
    
        $string = '';
        
        foreach($arr as $chave => $conteudo) {
            $string .= $chave . '*' . $conteudo . '|';
        }
        
        return $string;
        
    }
    
	/**
	 * Esta função converte uma string codificada em um array.
	 * Isso é preciso pois o wordpress não faz a conversão 
     * automática na hora de devolver um array no 
     * get_option / get_blog_option
	 *
	 * @param string $string texto codificado
	 * @return array Array associativo
	 */
	public static function stringToArray($string = "") {
        
        
        $arr = array();
        
        if(!$string) return $arr;
        
        $linhas = explode('|',$string);
        
        foreach ($linhas as $linha) {
            $elementos = explode('*',$linha);
            $arr[$elementos[0]] = $elementos[1];
        }
        
        return $arr;
        
    }
    
}


/**
 *  Adicionar HOOKs do WordPress
 */

$zhlPluginFile = substr(strrchr(dirname(__FILE__),DIRECTORY_SEPARATOR),1).DIRECTORY_SEPARATOR.basename(__FILE__);
/** Funcao de instalacao */
register_activation_hook($zhlPluginFile,array('zuraHotLinks','ativar'));
/** Função de desativação*/
register_deactivation_hook($zhlPluginFile,array('zuraHotLinks','desativar'));
/** Funcao de inicializacao */
add_filter('init', array('zuraHotLinks','inicializar'));
?>