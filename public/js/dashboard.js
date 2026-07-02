let carregando = false;
let expandido = false;

async function carregarRamais() {

    if (carregando) return;
    carregando = true;

    try {

        const req = await fetch('/api/ramais');

        if (!req.ok) {
            console.error('Erro HTTP', req.status);
            return;
        }

        const resposta = await req.json();

        if (resposta.erro) {
            console.log(resposta.mensagem);
            return;
        }

        const dados = resposta.ramais || [];
        const historico = resposta.historico || [];

        /*
        |--------------------------------------------------------------------------
        | RAMAIS
        |--------------------------------------------------------------------------
        */

        let html = '';

        dados.forEach((ramal, index) => {

            let texto = '';
            let destino = '';

            if (ramal.status === 'online') texto = 'Online';
            if (ramal.status === 'offline') texto = 'Offline';
            if (ramal.status === 'ligacao') texto = 'Em ligação';
            if (ramal.status === 'tocando') texto = 'Tocando';

            if (ramal.status === 'ligacao') {
                destino = `
                    <div class="destino mt-3">
                        Falando com<br>
                        <strong>${ramal.destino || '-'}</strong>
                    </div>
                `;
            }

            const hiddenClass =
                index >= 4
                    ? `ramal-extra ${expandido ? 'show' : ''}`
                    : '';

            html += `
                <div class="col-md-3 mb-4 ${hiddenClass}">
                    <div class="card card-ramal ${ramal.status}">
                        <div class="card-body text-center">
                            <div class="numero">${ramal.ramal}</div>
                            <div class="status">${texto}</div>
                            ${destino}
                        </div>
                    </div>
                </div>
            `;
        });

        if (dados.length > 4) {
            html += `
                <div class="col-12">
                    <div id="btnVerMais" class="ver-mais-container">
                        <div class="linha"></div>
                        <div class="icone-seta">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                </div>
            `;
        }

        const painel = document.getElementById('painel');

        if (painel) {

            painel.innerHTML = html;

            const btnVerMais = document.getElementById('btnVerMais');

            if (btnVerMais) {

                btnVerMais.addEventListener('click', () => {

                    expandido = !expandido;

                    document
                        .querySelectorAll('.ramal-extra')
                        .forEach((card, index) => {

                            if (expandido) {
                                setTimeout(() => {
                                    card.classList.add('show');
                                }, index * 150);
                            } else {
                                card.classList.remove('show');
                            }
                        });

                    const seta = btnVerMais.querySelector('.icone-seta');

                    seta.classList.toggle('rotacionado');
                });
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HISTÓRICO
        |--------------------------------------------------------------------------
        */

        let htmlHistorico = '';

        historico.forEach(item => {

            let badge = '';

            switch (item.status) {

                case 'ANSWERED':
                    badge = '<span class="badge bg-success">Atendida</span>';
                    break;

                case 'NO ANSWER':
                    badge = '<span class="badge bg-warning text-dark">Não Atendida</span>';
                    break;

                case 'BUSY':
                    badge = '<span class="badge bg-danger">Ocupado</span>';
                    break;

                default:
                    badge = `<span class="badge bg-secondary">${item.status}</span>`;
            }

            htmlHistorico += `
                <tr>
                    <td>${item.data}</td>
                    <td>${item.origem}</td>
                    <td>${item.destino}</td>
                    <td>${item.duracao}s</td>
                    <td>${badge}</td>
                </tr>
            `;
        });

        if (historico.length === 0) {
            htmlHistorico = `
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhuma ligação encontrada
                    </td>
                </tr>
            `;
        }

        const tabela = document.getElementById('historicoTabela');

        if (tabela) {
            tabela.innerHTML = htmlHistorico;
        }

        const hora = document.getElementById('hora');

        if (hora) {
            hora.innerHTML = new Date().toLocaleTimeString();
        }

    } catch (e) {

        console.error(e);

        const tabela = document.getElementById('historicoTabela');

        if (tabela) {
            tabela.innerHTML = `
                <tr>
                    <td colspan="5"
                        class="text-center text-danger">
                        Erro ao carregar histórico
                    </td>
                </tr>
            `;
        }

    } finally {

        carregando = false;
    }
}

carregarRamais();
setInterval(carregarRamais, 2000);