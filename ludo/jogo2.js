class Utils {
    static removerClasses(elemento, classe) {
        elemento.classList.remove.apply(
            elemento.classList,
            Array.from(elemento.classList).filter(v=> v.startsWith(classe))
        );
    }

    static obterElemento(contexto, dados) {
        if (contexto == 'casa-normal') {
            return document.querySelector(`.race-${dados.casa} .inner`);
        }
    }

    static apagarElementodoObjecto(contexto, chave, valor) {
        return contexto.filter(elemento => {
            return elemento[chave] !== valor;
        })
    }

    static consultar(variavel, variavel2) {
        return variavel.filter((row) =>
            variavel2.some((template) =>
                Object.keys(template).every((key) => template[key] === row[key])
            )
        );
    }

    static consultarIndice(variavel, variavel2) {
        return variavel.findIndex((row) =>
            variavel2.some((template) =>
                Object.keys(template).every((key) => template[key] === row[key])
            )
        );
    }
}

class Jogador extends EventEmitter {
    #event;

    constructor(options) {
        super();
        this.#event = new EventEmitter();

        for (const chave in options) {
            if (options.hasOwnProperty(chave)) {
                this[chave] = options[chave];
            }
        }
    }
}

class Pipeta {
    constructor(options) {
        for (const chave in options) {
            if (options.hasOwnProperty(chave)) {
                this[chave] = options[chave];
            }
        }
    }

    /**
     * devolver uma lista de casas onde uma pipeta possa estar
     *
     * @param pista
     * @param cor
     */
    static devolverPipetasDoJogador(pista, cor) {
        let casas = Utils.consultar(pista, [{
            'cor' : cor
        }]);

        let casasComPipetas = [];

        casas.forEach((casa) => {
            let pipetas = Utils.consultar(casa.pipetas, [{
                'cor' : cor
            }])

            if (pipetas.length > 0) {
                casasComPipetas.push(casa);
            }
        })

        return casasComPipetas;
    }

    static devolverOrigemPipeta(dados, pistas) {
        let numeroPipeta = Number(dados.el.title);
        let casaOndeEstaPipeta, casaEncontrada = [];

        Object.keys(pistas).forEach(pista => {
            let casas = this.devolverPipetasDoJogador(
                pistas[pista],
                dados.jogador.cor
            )
            if (casas.length > 0) {
                casas.forEach(casa => {
                    casaOndeEstaPipeta = Utils.consultar(casa.pipetas, [{
                        'numero' : numeroPipeta
                    }])
                    if (casaOndeEstaPipeta.length > 0) {
                        casaEncontrada = casa
                    }
                })
            }
        })

       return casaEncontrada;
    }
}

class Dado extends EventEmitter {
    #event;
    #el;
    #estado;
    #valorActual;
    #rolando;
    constructor(options) {
        super();

        this.#event = new EventEmitter();
        this.#el = document.querySelector(options.el);
        this.#estado = {};
        this.reset();
        this.render();
    }

    rolar() {
        if (!this.consultaEstado('rolando')) {
            this.setEstado('rolando', true);
            this.setEstado('valorActual', droll.roll('1d6').total);

            this.render();

            this.setEstado('rolando', false);
        }
    }

    colorir(cor) {
        this.cor = cor;
    }

    reset() {
        this.setEstado('valorActual', 0);
        this.setEstado('rolando', false);

        this.render();
    }

    render() {
        this.#el.querySelector('.show').classList.remove('show');

        if (this.cor !== '') {
            const valorActual = this.consultaEstado('valorActual');
            Utils.removerClasses(this.#el, 'dice-');

            this.#el.classList.add("dice-" + this.cor);
            this.#el.querySelector('.face-' + valorActual).classList.add('show');
        }
    }

    consultaEstado(chave) {
        return this.#estado[chave];
    }
    setEstado(chave, valor) {
        this.#estado[chave] = valor;
        return true;
    }
}

class Casa {
    constructor(options) {
        this.numero = options.numero;
        this.tipo = options.tipo ?? 'normal'; // normal // final // base
        this.segura = options.segura ?? false;
        this.cor = options.cor ?? 't';
        this.pipetas = options.pipetas ?? [];
    }


    apagarPipeta(numero) {
        const indicePipeta = this.pipetas.findIndex(pipeta => {
            return pipeta.numero === numero;
        });

        if (indicePipeta !== -1) {
            this.pipetas.splice(indicePipeta, 1);
        }
    }

    adicionarPipeta(pipeta) {
        this.pipetas.push(pipeta);
    }
}

class Tabuleiro extends EventEmitter {
    #event;
    #el;
    constructor(options) {
        super();
        this.#event = new EventEmitter();
        this.#el = document.querySelector(options.el);

        this.jogadoresCount   = options.jogadores ?? 1;
        this.casaDosJogadores = [
            {cor:'r', classe: 'red',    casaPartida : 1,  casaFinal: 51},
            {cor:'g', classe: 'green',  casaPartida : 14, casaFinal: 12},
            {cor:'y', classe: 'yellow', casaPartida : 27, casaFinal: 25},
            {cor:'b', classe: 'blue',   casaPartida : 40, casaFinal: 38}
        ];

        this.jogadores = [];

        this.pistas = {
            pista: [],
            final: [],
            base: [],
        }
        this.casasNormais = 52;
        this.casasFinais = 6;
        this.casasBase = 4;

        // definir as pistas normais de corrida
        for (var i = 1; i <= this.casasNormais; i++) {
            let seguranca = [1, 9, 14, 22, 27, 35, 40, 48].includes(i);
            this.pistas.pista.push(new Casa({tipo: 'normal', segura: seguranca, numero: i}));
        }

        // definir os jogadores e as respectivas casas
        for (var i = 1; i <= this.jogadoresCount; i++) {
            this.jogadores.push(new Jogador(this.casaDosJogadores[i-1]));
            let cor = this.casaDosJogadores[i-1].cor;

            for (var j = 1; j <= this.casasFinais; j++) {
                this.pistas.final.push(new Casa({tipo: 'final', cor : cor, numero: j}));
            }

            for (var j = 1; j <= this.casasBase; j++) {
                let pipeta = new Pipeta({cor: cor, numero: j});
                this.pistas.base.push(new Casa({tipo: 'base', cor : this.casaDosJogadores[i-1].cor, 'pipetas' : [pipeta], numero: j }));
            }
        }

        this.render();
    }

    moverPipeta(el, opcoes) {
        /* modificações à DOM genéricas */
        console.log('mover pipeta', opcoes);
        this.desActivarPipetas(opcoes.jogador.cor);
        /**
         * Remover os objectos Pipeta da casa de origem
         */
        //opcoes.casa_origem_pipeta.pipetas;
        let pista = this.pistas[opcoes.casa_origem_pipeta.tipo];

        let casaOrigemIndice = Utils.consultarIndice(pista, [{
            'numero' : opcoes.casa_origem_pipeta.numero
        }]);

        let casaOrigem, pipetaOrigem, casaAlvo = {};
        let elementoAlvo;

        if (this.pistas[opcoes.casa_origem_pipeta.tipo][casaOrigemIndice]) {
            casaOrigem = this.pistas[opcoes.casa_origem_pipeta.tipo][casaOrigemIndice];
            let pipetaIndice = Utils.consultarIndice(casaOrigem.pipetas, [{
                'numero' : opcoes.casa_origem_pipeta.numero
            }]);

            pipetaOrigem = opcoes.casa_origem_pipeta.pipetas[pipetaIndice];
            casaOrigem.apagarPipeta(pipetaOrigem.numero)
        }
        else {
            throw('falha ao remover pipeta da casa de origem')
        }

        //analisar a origem para poder colocar na pista certa
        let numeroAlvoPesquisa = 0;
        let tipoPistaAlvo = '';
        let casaAlvoIndice = 0;
        let colocarEmQuePista = '';

        if (casaOrigem.tipo === 'base') {
            tipoPistaAlvo = 'casa-normal';
            colocarEmQuePista = 'pista';
            numeroAlvoPesquisa = opcoes.jogador.casaPartida
        }

        //DOM meter na pista do jogador
        elementoAlvo = Utils.obterElemento(tipoPistaAlvo, {
            casa : numeroAlvoPesquisa
        });

        elementoAlvo.appendChild(el);

        //ARRAY meter na pista alvo
        casaAlvoIndice = Utils.consultarIndice(pista, [{
            'numero' : numeroAlvoPesquisa
        }]);

        if (this.pistas[colocarEmQuePista][casaAlvoIndice]) {
            casaAlvo = this.pistas[colocarEmQuePista][casaAlvoIndice];
            casaAlvo.adicionarPipeta(pipetaOrigem)
        }

        //console.log('el alvo', casaAlvo);
        //this.pistas[colocarEmQuePista][casaAlvoIndice] = casaAlvo;

            //this.pistas[opcoes.casa_origem_pipeta.tipo].pipetas =
                /*Utils.apagarElemento(
                this.pistas[opcoes.casa_origem_pipeta.tipo.pipetas],
                'numero',
                opcoes.casa_origem_pipeta.pipetas.numero
                )
        console.log(this.pistas[opcoes.casa_origem_pipeta.tipo])*/
        /* modificações á dom */
        /*if (opcoes.origem === 'base') {
            let pipetaOrigem = Utils.consultar(
                this.pistas.base,
                [{
                    cor : jogador.cor
                }]
            );
            console.log('origem', pipetaOrigem);
        }*/

        /* modificações á pista */
        console.log(this.pistas[colocarEmQuePista]);

        this.emit('tabuleiro.pipeta.movida', {});
    }

    podeMoverPipeta(el, casaActual, casaDestino){
        
    }


    escolherPipeta(dados) {
        let casaContemPipeta = Pipeta.devolverOrigemPipeta(
            dados,
            this.pistas
        );
        if (casaContemPipeta) {
            this.moverPipeta(dados.el, {
                jogador: dados.jogador,
                casa_origem_pipeta : casaContemPipeta
            })
        }
    }

    /*activarPipetas(cor, pipetasParaAtivar) {
        // TODO adicionar lógica para distinguir entre base, normal e final
        pipetasParaAtivar.base.forEach(casa => {
            let el = this.#el.querySelector(`.base.${cor} .token:nth-of-type(${casa.numero})`)
            el.classList.add('active');
        })

        /*pipetasParaAtivar.base.forEach(casa => {
            let el = this.#el.querySelector(`.base.${cor} .token:nth-of-type(${casa.numero})`)
            el.classList.add('active');
        })*/

    //}
    desActivarPipetas(cor) {
        // TODO adicionar lógica para distinguir entre base, normal e final
        this.#el.querySelectorAll(`.base.${cor} .token`).forEach(el => {
            Utils.removerClasses(el, 'active')
        });
    }
    activarPipeta(pipeta, casa, jogador) {
        let selector = '';
        let cor = jogador.cor;

        if (casa.tipo === 'base') {
            selector = `.${casa.tipo}.${cor} .token[title="${casa.numero}"]`;
        }
        if (casa.tipo === 'normal') {
            selector = `.race-${casa.numero} .token[title="${pipeta.numero}"]`;
        }

        let el = this.#el.querySelector(selector)
        el.classList.add('active');
    }

    renderSafeZones() {
        let casas_seguras = this.pistas.pista.filter(casa => casa.segura);
        casas_seguras.forEach(casa => {
            document.querySelector(".race-" + casa.numero).classList.add("safe-zone");
        });
    }

    render() {
        this.renderSafeZones();
    }



    info(contexto) {
        switch(contexto) {
            case 1 : {
                console.log(this.jogadoresCount);
                console.log(this.casaDosJogadores);
                console.log(this.jogadores);
                break;
            }

            case 2: {
                console.log(this.pistas);
                break;
            }

            case 3: {
                console.log(this.casasNormais = 52, this.casasFinais = 6, this.casasBase = 4);
                break;
            }

            default : {
                console.log(this);
                break;
            }
        }
    }

    consultarCDJ(chave, valor) {
        return this.casaDosJogadores.filter(jogador => jogador[chave] === valor)[0];
    }

}

class Jogo extends EventEmitter {
    #event;
    #estado = {};
    constructor(options) {
        super();

        this.dado = options.dado;
        this.tabuleiro = options.tabuleiro;

        this.#event = new EventEmitter();
        this.setEstado('jogadorActual', -1);
        this.setEstado('impedirJogada', false);

        // definir eventos
        this.tabuleiro.on('tabuleiro.pipeta.movida', function(dados) {
            this.setEstado('impedirJogada', false);
            this.dado.reset();
        }.bind(this))
    }


    escolherPipeta(el) {
        this.setEstado('impedirJogada', true);
        const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];

        console.log('pipeta escolhida', el);
        this.tabuleiro.escolherPipeta({
            el: el,
            jogador : jogador
        });
    }

    jogadorPodeMover(dados) {
        //TODO REVISITAR ESTA FUNÇÃO quando já temos pipetas a correr.
        let casasAtivar = {
            'pista' : [],
            'base'  : [],
            'final' : []
        };
        const valorDoDado = dados.dadoValorActual;
        const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];
        console.log('dado', dados);
        console.log('pistas', this.tabuleiro.pistas);

        // obter a lista das pipetas e saber em que casas elas estão
        if (valorDoDado === 6) {
            // TODO promover a uma função
            Utils.consultar(
                this.tabuleiro.pistas.base,
                [{
                    'cor' : jogador.cor
                }]
            ).forEach(casa => {
                Utils.consultar(
                    casa.pipetas,
                    [{
                    'cor' : jogador.cor
                    }]
                ).forEach(pipeta => {
                    this.tabuleiro.activarPipeta(pipeta, casa, jogador);
                })
            })
        }

        Utils.consultar(
            this.tabuleiro.pistas.pista,
            [{
                'cor' : 't'
            }]
        ).forEach(casa => {
            // TODO verificar se o número da casa é maior que a casa do jogador.
            Utils.consultar(
                casa.pipetas,
                [{
                    'cor' : jogador.cor
                }]
            ).forEach(pipeta => {
                this.tabuleiro.activarPipeta(pipeta, casa, jogador);
            })
        })
        /*let casasDaBase = Pipeta.devolverPipetasDoJogador(
            this.tabuleiro.pistas.base,
            jogador.cor
        )

        if (dados.dadoValorActual === 6 && casasDaBase.length > 0) {
            casasAtivar.base = casasDaBase;
        }

        let casasDaPista = Pipeta.devolverPipetasDoJogador(
            this.tabuleiro.pistas.pista,
            jogador.cor
        );

        let casasDaFinal = Pipeta.devolverPipetasDoJogador(
            this.tabuleiro.pistas.final,
            jogador.cor
        );

        if (casasDaPista.length > 0) {
            console.log('casascasasDaPista)
            let contador = dados.dadoValorActual + casa.numero;
            /*if (contador > this.tabuleiro.casasNormais) {
                contador = 1;
            }*/
            // TODO verificar se cada numero da casa + o valor do dado é superior ao número máximo de casas normais
            //  Se sim fazer reset ao "contador"
            // TODO verificar se cada numero da casa + o valor dos dados é menor ou igual ao valor da casa Final + o número de casas na pista final
                // se sim, pode mover para dentro da
                // se sim, então pode mover
            /*casasAtivar.pista = casasDaPista;
        }

        if (casasDaFinal.length > 0) {
            casasAtivar.final = casasDaFinal;
        }*/



        /*;

        casasComipetasDoJogador = casasComipetasDoJogador.concat();*/


        // se dados === 6 então
            //ativar todas as pipetas dele
        // se não
            //ativar todas as pipetas
                // que estiverem na corrida

                // que estiverem na faixa final e cujo valor não passe da meta final



        /*const pipetasNaCasa = Utils.consultar(
            this.tabuleiro.pistas.pista,
            'numero',
            dados.dadoValorActual
        )[0]*/

        //if (pipetasNaCasa) {

            //console.log(pipetasNaCasa.pipetas);
        //}

        /*if (this.jogadorTemPipetasCorrendo()) {
            console.log("tem pipetas correndo")
        }
        else {
            console.log("n tem pipetas correndo")
        }*/

        return true;
    }

    activarPipetas(pipetasParaActivar) {
        this.setEstado('impedirJogada', true);
        const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];
        console.log("jogoa ativar pips", pipetasParaActivar);
        this.tabuleiro.activarPipetas(jogador.cor, pipetasParaActivar);
    }

    jogadorSeguinte() {
        let jogadorActual = this.consultaEstado('jogadorActual');
        jogadorActual += 1;

        if (jogadorActual == this.tabuleiro.jogadoresCount) {
            jogadorActual = 0;
        }
        this.setEstado('jogadorActual', jogadorActual);

        const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];

        //definir o layout do dado e renderizar
        this.dado.reset();
        this.dado.colorir(jogador.cor);
        this.dado.render();
        this.setEstado('impedirJogada', false);
    }

    vezSeguinte() {
        if (!this.consultaEstado('impedirJogada')) {
            this.setEstado('impedirJogada', true);

            const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];

            //definir o layout do dado e rolar
            this.dado.colorir(jogador.cor);
            this.dado.rolar();

            this.emit('jogo.terminouturno', {
                jogadorActual: this.consultaEstado('jogadorActual'),
                dadoValorActual: this.dado.consultaEstado('valorActual')
            });
        }
        else {
            console.log('não pode jogar');
        }
    }

    consultaEstado(chave) {
        return this.#estado[chave];
    }
    setEstado(chave, valor) {
        this.#estado[chave] = valor;
        return true;
    }
}