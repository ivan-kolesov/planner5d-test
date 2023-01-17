import Api from '../common/Api';
import Dom from '../common/Dom';
import {applyMixins} from '../common/mixins';
import {Project} from '../common/types';

const PROJECT_PATH = '/project';

class ProjectPage {
    constructor(id: string, baseUrl: string) {
        this.initDom(id);
        this.initApi(baseUrl);
    }

    renderPage({title, canvas_link, hits}: Project) {
        const wrapperNode = this.createElement<HTMLDivElement>('div', ['container']);

        const headerWrapper = this.createElement<HTMLDivElement>('div', ['header']);
        const titleNode = this.createElement<HTMLHeadElement>('h1', [], {}, title);
        const hitsNode = this.createElement<HTMLHeadElement>('div', ['statistics'], {}, `Hits: ${hits}`);

        headerWrapper.appendChild(titleNode);
        headerWrapper.appendChild(hitsNode);

        wrapperNode.appendChild(headerWrapper);

        const canvasNode = this.createElement<HTMLHeadElement>('object', ['canvas'], {
            data: canvas_link,
            type: 'text/html',
            width: '100%',
            height: '400',
        });
        wrapperNode.appendChild(canvasNode);

        this.render(wrapperNode);

        const canvasHeight = window.innerHeight - canvasNode.offsetTop;
        canvasNode.setAttribute('height', canvasHeight.toString())
    }

    async fetchProject(id: number): Promise<void> {
        const response = await this.fetch<Project>(`${PROJECT_PATH}/${id}`);
        this.renderPage(response)
    }
}

interface ProjectPage extends Api, Dom {}
applyMixins(ProjectPage, [Api, Dom]);

export default ProjectPage;
