import AdminLayout from '@/Layouts/AdminLayout';
import { Link, router, usePage } from '@inertiajs/react';
import { Plus, Pencil, Trash2, Eye, EyeOff, GripVertical, ChevronUp, ChevronDown } from 'lucide-react';
import { useState, useRef } from 'react';

export default function ProjectsIndex({ projects: initialProjects }) {
    const { props } = usePage();
    const flash = props.flash || {};
    const [projects, setProjects] = useState(initialProjects || []);
    const [saving, setSaving] = useState(false);
    const [saved, setSaved] = useState(false);

    // Drag state
    const dragItem = useRef(null);
    const dragOverItem = useRef(null);

    const togglePublish = (id) => router.post(`/admin/projects/${id}/toggle-publish`, {}, { preserveScroll: true });
    const destroy = (id) => confirm('Delete this project?') && router.delete(`/admin/projects/${id}`);

    // Move up/down buttons
    const moveUp = (index) => {
        if (index === 0) return;
        const updated = [...projects];
        [updated[index - 1], updated[index]] = [updated[index], updated[index - 1]];
        setProjects(updated);
        saveOrder(updated);
    };

    const moveDown = (index) => {
        if (index === projects.length - 1) return;
        const updated = [...projects];
        [updated[index], updated[index + 1]] = [updated[index + 1], updated[index]];
        setProjects(updated);
        saveOrder(updated);
    };

    // Drag handlers
    const onDragStart = (e, index) => {
        dragItem.current = index;
        e.dataTransfer.effectAllowed = 'move';
    };

    const onDragEnter = (e, index) => {
        dragOverItem.current = index;
        e.preventDefault();
    };

    const onDragOver = (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    };

    const onDrop = (e) => {
        e.preventDefault();
        if (dragItem.current === null || dragOverItem.current === null) return;
        if (dragItem.current === dragOverItem.current) return;
        const updated = [...projects];
        const [dragged] = updated.splice(dragItem.current, 1);
        updated.splice(dragOverItem.current, 0, dragged);
        dragItem.current = null;
        dragOverItem.current = null;
        setProjects(updated);
        saveOrder(updated);
    };

    const saveOrder = async (ordered) => {
        setSaving(true);
        setSaved(false);
        try {
            await fetch('/admin/projects/reorder', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ order: ordered.map(p => p.id) }),
            });
            setSaved(true);
            setTimeout(() => setSaved(false), 2000);
        } catch (e) {
            console.error(e);
        } finally {
            setSaving(false);
        }
    };

    return (
        <AdminLayout title="Projects">
            <div className="space-y-6">
                {flash.success && (
                    <div className="p-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-xl text-sm border border-green-200 dark:border-green-700">
                        ✓ {flash.success}
                    </div>
                )}

                <div className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <h2 className="font-bold text-slate-900 dark:text-white text-xl">All Projects</h2>
                        {saving && <span className="text-xs text-slate-400 animate-pulse">Saving order...</span>}
                        {saved && <span className="text-xs text-green-500">✓ Order saved!</span>}
                    </div>
                    <Link href="/admin/projects/create" className="btn-primary text-sm">
                        <Plus size={16}/> Add Project
                    </Link>
                </div>

                <p className="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                    <GripVertical size={12}/> Drag rows to reorder, or use ↑↓ buttons. Order is saved automatically.
                </p>

                <div className="card overflow-hidden">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                {['', '#', 'Title', 'Tech Stack', 'Status', 'Actions'].map(h => (
                                    <th key={h} className="text-left px-4 py-3 text-slate-500 dark:text-slate-400 font-semibold text-xs uppercase tracking-wider">{h}</th>
                                ))}
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 dark:divide-slate-700">
                            {projects.map((p, index) => (
                                <tr
                                    key={p.id}
                                    draggable
                                    onDragStart={(e) => onDragStart(e, index)}
                                    onDragEnter={(e) => onDragEnter(e, index)}
                                    onDragOver={onDragOver}
                                    onDrop={onDrop}
                                    className="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-grab active:cursor-grabbing active:opacity-60"
                                >
                                    {/* Drag handle */}
                                    <td className="px-2 py-3 text-slate-300 dark:text-slate-600">
                                        <GripVertical size={16}/>
                                    </td>
                                    {/* Order number */}
                                    <td className="px-2 py-3">
                                        <div className="flex flex-col gap-0.5">
                                            <button onClick={() => moveUp(index)} disabled={index === 0}
                                                className="text-slate-400 hover:text-blue-500 disabled:opacity-20 transition-colors">
                                                <ChevronUp size={14}/>
                                            </button>
                                            <span className="text-xs font-mono text-slate-400 text-center">{index + 1}</span>
                                            <button onClick={() => moveDown(index)} disabled={index === projects.length - 1}
                                                className="text-slate-400 hover:text-blue-500 disabled:opacity-20 transition-colors">
                                                <ChevronDown size={14}/>
                                            </button>
                                        </div>
                                    </td>
                                    <td className="px-4 py-3 font-medium text-slate-900 dark:text-white max-w-[200px]">
                                        <div className="truncate">{p.title_en}</div>
                                    </td>
                                    <td className="px-4 py-3">
                                        <div className="flex flex-wrap gap-1">
                                            {(p.tech_stack || []).slice(0, 3).map(t => (
                                                <span key={t} className="badge-blue text-xs">{t}</span>
                                            ))}
                                            {(p.tech_stack || []).length > 3 && (
                                                <span className="badge-slate text-xs">+{p.tech_stack.length - 3}</span>
                                            )}
                                        </div>
                                    </td>
                                    <td className="px-4 py-3">
                                        <button onClick={() => togglePublish(p.id)}
                                            className={`badge text-xs font-medium cursor-pointer transition-colors flex items-center gap-1 ${p.is_published ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400'}`}>
                                            {p.is_published ? <Eye size={12}/> : <EyeOff size={12}/>}
                                            {p.is_published ? 'Published' : 'Draft'}
                                        </button>
                                    </td>
                                    <td className="px-4 py-3">
                                        <div className="flex gap-2">
                                            <Link href={`/admin/projects/${p.id}/edit`} className="btn-ghost p-1.5 text-xs">
                                                <Pencil size={14}/>
                                            </Link>
                                            <button onClick={() => destroy(p.id)} className="btn-ghost p-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                <Trash2 size={14}/>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                            {(!projects || projects.length === 0) && (
                                <tr><td colSpan={6} className="px-4 py-8 text-center text-slate-400">No projects yet. Add one!</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
