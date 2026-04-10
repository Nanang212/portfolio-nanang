import AdminLayout from '@/Layouts/AdminLayout';
import { Link, useForm } from '@inertiajs/react';
import { ArrowLeft, Save, Plus, Trash2, GripVertical, ChevronUp, ChevronDown } from 'lucide-react';
import { useRef } from 'react';

export default function ExperienceForm({ experience }) {
    const isEditing = !!experience;

    const parseProjects = (data) => {
        if (!data) return [{ name: '', description_en: '', description_id: '' }];
        if (Array.isArray(data)) return data.length > 0 ? data : [{ name: '', description_en: '', description_id: '' }];
        try { return JSON.parse(data); } catch { return [{ name: '', description_en: '', description_id: '' }]; }
    };

    const { data, setData, post, put, processing, errors } = useForm({
        company:      experience?.company || '',
        role:         experience?.role || '',
        period_start: experience?.period_start?.substring(0, 10) || '',
        period_end:   experience?.period_end?.substring(0, 10) || '',
        is_current:   experience?.is_current ?? false,
        tech_stack:   Array.isArray(experience?.tech_stack)
                        ? experience.tech_stack.join(', ')
                        : (experience?.tech_stack || ''),
        projects:     parseProjects(experience?.projects),
        order:        experience?.order || 0,
    });

    // Project CRUD
    const addProject = () => setData('projects', [...data.projects, { name: '', description_en: '', description_id: '' }]);
    const removeProject = (i) => setData('projects', data.projects.filter((_, idx) => idx !== i));
    const updateProject = (i, field, value) => {
        const updated = [...data.projects];
        updated[i] = { ...updated[i], [field]: value };
        setData('projects', updated);
    };

    // Reorder helpers
    const moveProjectUp = (i) => {
        if (i === 0) return;
        const updated = [...data.projects];
        [updated[i - 1], updated[i]] = [updated[i], updated[i - 1]];
        setData('projects', updated);
    };

    const moveProjectDown = (i) => {
        if (i === data.projects.length - 1) return;
        const updated = [...data.projects];
        [updated[i], updated[i + 1]] = [updated[i + 1], updated[i]];
        setData('projects', updated);
    };

    // Drag-and-drop state
    const dragItem = useRef(null);
    const dragOverItem = useRef(null);

    const onDragStart = (e, i) => {
        dragItem.current = i;
        e.dataTransfer.effectAllowed = 'move';
    };

    const onDragEnter = (e, i) => {
        dragOverItem.current = i;
        e.preventDefault();
    };

    const onDragOver = (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    };

    const onDrop = (e) => {
        e.preventDefault();
        const from = dragItem.current;
        const to = dragOverItem.current;
        if (from === null || to === null || from === to) return;
        const updated = [...data.projects];
        const [moved] = updated.splice(from, 1);
        updated.splice(to, 0, moved);
        dragItem.current = null;
        dragOverItem.current = null;
        setData('projects', updated);
    };

    const submit = (e) => {
        e.preventDefault();
        isEditing ? put(`/admin/experiences/${experience.id}`) : post('/admin/experiences');
    };

    return (
        <AdminLayout title={isEditing ? 'Edit Experience' : 'Add Experience'}>
            <div className="max-w-2xl">
                <Link href="/admin/experiences" className="btn-ghost text-sm mb-6 inline-flex">
                    <ArrowLeft size={16}/> Back
                </Link>

                <form onSubmit={submit} className="space-y-6">
                    {/* Company / Role */}
                    <div className="card p-6 space-y-4">
                        <h3 className="font-semibold text-slate-800 dark:text-white">Company Info</h3>
                        <div className="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Company *</label>
                                <input className="input" value={data.company} onChange={e => setData('company', e.target.value)} placeholder="Jasa Marga"/>
                                {errors.company && <p className="text-red-500 text-xs mt-1">{errors.company}</p>}
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Role / Position *</label>
                                <input className="input" value={data.role} onChange={e => setData('role', e.target.value)} placeholder="Fullstack Developer"/>
                                {errors.role && <p className="text-red-500 text-xs mt-1">{errors.role}</p>}
                            </div>
                        </div>
                        <div className="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Start Date</label>
                                <input type="date" className="input" value={data.period_start} onChange={e => setData('period_start', e.target.value)}/>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">End Date</label>
                                <input type="date" className="input" value={data.period_end} onChange={e => setData('period_end', e.target.value)} disabled={data.is_current}/>
                            </div>
                        </div>
                        <div className="flex items-center gap-3">
                            <input type="checkbox" id="is_current" checked={data.is_current}
                                onChange={e => setData('is_current', e.target.checked)}
                                className="w-4 h-4 accent-primary-600 rounded"/>
                            <label htmlFor="is_current" className="text-sm font-medium text-slate-700 dark:text-slate-300">
                                Currently working here
                            </label>
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tech Stack (comma separated)</label>
                            <input className="input" value={data.tech_stack} onChange={e => setData('tech_stack', e.target.value)} placeholder="Laravel, Docker, Redis"/>
                        </div>
                    </div>

                    {/* Projects / Responsibilities */}
                    <div className="card p-6 space-y-4">
                        <div className="flex items-center justify-between">
                            <div>
                                <h3 className="font-semibold text-slate-800 dark:text-white">Projects / Responsibilities</h3>
                                <p className="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                    <GripVertical size={11}/> Drag to reorder, or use ↑↓ buttons
                                </p>
                            </div>
                            <button type="button" onClick={addProject} className="btn-ghost text-xs">
                                <Plus size={14}/> Add
                            </button>
                        </div>

                        <div className="space-y-3">
                            {data.projects.map((proj, i) => (
                                <div
                                    key={i}
                                    draggable
                                    onDragStart={(e) => onDragStart(e, i)}
                                    onDragEnter={(e) => onDragEnter(e, i)}
                                    onDragOver={onDragOver}
                                    onDrop={onDrop}
                                    className="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 space-y-3 border border-transparent hover:border-primary-200 dark:hover:border-primary-800 transition-colors cursor-grab active:cursor-grabbing active:opacity-60"
                                >
                                    {/* Top bar: drag handle + order number + title preview + controls */}
                                    <div className="flex items-center gap-2">
                                        {/* Drag + order controls */}
                                        <div className="flex flex-col items-center gap-0.5 shrink-0">
                                            <GripVertical size={15} className="text-slate-300 dark:text-slate-600"/>
                                            <button type="button" onClick={() => moveProjectUp(i)} disabled={i === 0}
                                                className="text-slate-400 hover:text-blue-500 disabled:opacity-20 transition-colors">
                                                <ChevronUp size={13}/>
                                            </button>
                                            <span className="text-xs font-mono text-slate-400 leading-none">{i + 1}</span>
                                            <button type="button" onClick={() => moveProjectDown(i)} disabled={i === data.projects.length - 1}
                                                className="text-slate-400 hover:text-blue-500 disabled:opacity-20 transition-colors">
                                                <ChevronDown size={13}/>
                                            </button>
                                        </div>

                                        {/* Project name input */}
                                        <input
                                            className="input flex-1 font-medium"
                                            placeholder="Project name (e.g. JIMMS, PREIBALAP)"
                                            value={proj.name}
                                            onChange={e => updateProject(i, 'name', e.target.value)}
                                            onClick={e => e.stopPropagation()}
                                        />

                                        {/* Delete button */}
                                        <button type="button" onClick={() => removeProject(i)}
                                            className="btn-ghost p-1.5 text-red-400 hover:text-red-600 shrink-0">
                                            <Trash2 size={14}/>
                                        </button>
                                    </div>

                                    {/* Descriptions */}
                                    <textarea
                                        className="input resize-none"
                                        rows={2}
                                        placeholder="Description (English)"
                                        value={proj.description_en}
                                        onChange={e => updateProject(i, 'description_en', e.target.value)}
                                    />
                                    <textarea
                                        className="input resize-none"
                                        rows={2}
                                        placeholder="Deskripsi (Indonesia)"
                                        value={proj.description_id}
                                        onChange={e => updateProject(i, 'description_id', e.target.value)}
                                    />
                                </div>
                            ))}

                            {data.projects.length === 0 && (
                                <div className="text-center py-8 text-slate-400 text-sm border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl">
                                    No projects added yet. Click <strong>+ Add</strong> to add one.
                                </div>
                            )}
                        </div>
                    </div>

                    <button type="submit" disabled={processing} className="btn-primary w-full justify-center">
                        <Save size={16}/> {isEditing ? 'Save Changes' : 'Create Experience'}
                    </button>
                </form>
            </div>
        </AdminLayout>
    );
}
