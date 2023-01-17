import Api from '../common/Api';
import Dom from '../common/Dom';
import {applyMixins} from '../common/mixins';
import {Project, ProjectListResponse} from '../common/types';

const PROJECT_LIST_PATH = '/list';
const PROJECT_PATH = '/project';

class ProjectList {
    constructor(id: string, baseUrl: string) {
        this.initDom(id);
        this.initApi(baseUrl);
    }

    createListItemNode({title, id}: Project): HTMLDivElement {
        const wrapperNode = this.createElement<HTMLDivElement>('div', ['list-item']);

        const titleNode = this.createElement<HTMLAnchorElement>(
            'a',
            ['list-item-title'],
            {href: `${PROJECT_PATH}/${id}`},
            title
        );

        wrapperNode.appendChild(titleNode);

        return wrapperNode;
    }

    async fetchList(): Promise<void> {
        const response = await this.fetch<ProjectListResponse>(PROJECT_LIST_PATH);
        const items = Object(response.data)
            .slice()
            .sort((a: Project, b: Project) => a.order_pos < b.order_pos ? - 1 : 1)
            .map((item: Project) => this.createListItemNode(item));
        this.rerender(items);
    }
}

interface ProjectList extends Api, Dom {}
applyMixins(ProjectList, [Api, Dom]);

export default ProjectList;
